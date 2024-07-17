<?php

namespace App\Repositories;

use App\Enums\Division\PaymentStatusEnum;
use App\Enums\Division\PaymentStatusValEnum;
use App\Events\Manager\Divisions\LeagueTeamsPaymentEvent;
use App\Mail\Manager\Divisions\LeaguePaymentByOtherMail;
use App\Models\Consumer;
use App\Models\DivisionPaymentDetail;
use App\Models\DivisionPaymentSelectedTeam;
use App\Models\DivisionTeam;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;
use Mail;
use Worldpay;
use WorldpayException;

class LeaguePaymentRepository
{
    public function getCheckoutData($data, $division, User $user)
    {
        $clientKey = config('services.worldpay.client_key');
        //$price = $division->getPrice();
        $teams = json_encode(array_keys($data['teams']));
        $price = array_values($data['teams']);
        //$amount = $price * count($data['teams']);
        $amount = array_sum($price);

        $divisionSelect = DivisionPaymentSelectedTeam::firstOrNew([
            'division_id'   => $division->id,
            'manager_id'    => $user->consumer->id,
            'token'     => $data['_token'],
        ]);
        $divisionSelect->teams = implode(',', array_keys($data['teams']));
        $divisionSelect->amount = $amount;
        $divisionSelect->save();

        return compact('clientKey', 'division', 'amount', 'teams');
    }

    public function makePayment($data, $division, User $user)
    {
        $message = '';
        $worldpay = new Worldpay(config('services.worldpay.service_key'));
        $currency = config('fantasy.currency.default.format');
        $consumer = $user->consumer;

        $price = $division->getPrice();
        $name = $user->first_name.' '.$user->last_name;
        // Strip any special characters from name string, as otherwise
        // WorldPay throws an exception. See #671 for details.
        $name = preg_replace('/[^a-zA-Z0-9 ]/', '', $name);

        $divisionSelect = DivisionPaymentSelectedTeam::where('token', $data['_token'])->where('division_id', $division->id)->latest()->first();

        if ($divisionSelect->count() == 0) {
            $message = 'ERROR!';

            return compact('message');
        }

        $unPaidSelected = DivisionTeam::where('team_id', explode(',', $divisionSelect['teams']))->notPaid();

        if ($unPaidSelected->count() == 0) {
            $message = 'ERROR!';

            return compact('message');
        }

        DivisionPaymentDetail::where('token', $data['token'])->where('division_id', $division->id)->latest()->first();

        $divisionPaymentDetail = DivisionPaymentDetail::create(
            [
                'division_id'   => $division->id,
                'manager_id'    => $consumer->id,
                'token'         => $data['token'],
            ]
        );

        $billingAddress = [
            'address1'      => $consumer->address_1,
            'address2'      => $consumer->address_2,
            'address3'      => '',
            'postalCode'    => $consumer->post_code,
            'city'          => $consumer->town,
            'state'         => '',
            'countryCode'   => '',
        ];

        $response = $result = $teams = [];
        $denomination = config('fantasy.currency.default.denomination');

        try {
            $response = $worldpay->createOrder([
                'currencyCode'      => $currency,
                'amount'            => $divisionSelect->amount * $denomination,
                'token'             => $data['token'],
                'name'              => $name,
                'billingAddress'    => $billingAddress,
                'orderDescription'  => 'League '.$division->name.' - Team Payment Order',
                'customerOrderCode' => $divisionPaymentDetail->id,
            ]);

            if ($response['paymentStatus'] === 'SUCCESS') {
                $message = $response['paymentStatus'];
                $divisionPaymentDetail->worldpay_ordercode = $response['orderCode'];
                $divisionPaymentDetail->amount = $divisionSelect['amount'];
                $divisionPaymentDetail->save();

                foreach (explode(',', $divisionSelect['teams']) as $team) {
                    $divisionTeam = DivisionTeam::where('division_id', $division->id)->where('team_id', $team)->first();
                    $divisionTeam->payment_id = $divisionPaymentDetail->id;
                    $divisionTeam->save();
                    $teams[] = $divisionTeam;
                }
                $teams['freeCount'] = DivisionTeam::whereIn('team_id', explode(',', $divisionSelect['teams']))->where('is_free', 1)->count();
                $paymentDetails['teams'] = $teams;
                $paymentDetails['division'] = $division;
                $paymentDetails['user'] = $user;
                $paymentDetails['amount'] = $divisionSelect->amount;
                $paymentDetails['price'] = $price;
                $paymentDetails['message'] = 'Donec facilisis tortor ut augue lacinia, at viverra est semper. Sed sapien metus, scelerisque nec pharetra id, tempor a tortor.';
                $paymentDetails['divisionPaymentDetail'] = $divisionPaymentDetail;
                foreach ($paymentDetails['teams'] as $key=>$team) {
                    if (is_numeric($key)) {
                        $teamDeatail = Team::find($team->team_id);
                        $teamUser = Consumer::find($teamDeatail->manager_id);
                        $paymentDetails['toUser'] = $teamUser->user;
                        // Fire off the event
                        if ($user->consumer->id == $teamDeatail->manager_id) {
                            event(new LeagueTeamsPaymentEvent($paymentDetails));
                        } else {
                            $mail = Mail::to($teamUser->user->email)->send(new LeaguePaymentByOtherMail($teamDeatail, $user));
                        }
                    }
                }
            } else {
                throw new WorldpayException(print_r($response, true));
            }
        } catch (WorldpayException $e) {
            $message = 'Error code: '.$e->getCustomCode().'
            HTTP status code:'.$e->getHttpStatusCode().'
            Error description: '.$e->getDescription().'
            Error message: '.$e->getMessage();
        } catch (Exception $e) {
            $message = 'Error message: '.$e->getMessage();
        }
        $divisionPaymentDetail->status = $response['paymentStatus'];
        $divisionPaymentDetail->save();

        return compact('message', 'teams', 'price', 'divisionPaymentDetail');
    }

    public function getUnpaidLeagueTeams($division_id, $consumer = '', $others = false)
    {
        $divisionTeams = DivisionTeam::where('division_id', $division_id)->where('season_id', Season::getLatestSeason())
        ->with(['team', 'division.package'])->notPaid();
        $divisionTeams->whereHas('division.package', function ($query) {
            $query->where('price', '<>', 0);
        });
        $divisionTeams->whereHas('team', function ($query) use ($consumer, $others) {
            if ($consumer) {
                if ($others) {
                    $query->where('manager_id', '<>', $consumer->id);
                } else {
                    $query->where('manager_id', $consumer->id);
                }
            }
        });

        return $divisionTeams;
    }

    public function getLeaguePaymentStatus($division, $consumer)
    {
        $ownUnpaidTeams = $this->getUnpaidLeagueTeams($division->id, $consumer);
        $otherUnpaidTeams = $this->getUnpaidLeagueTeams($division->id, $consumer, $others = true);

        if ($ownUnpaidTeams->count() == 0 && $otherUnpaidTeams->count() == 0) {
            return PaymentStatusValEnum::PAID;
        } else {
            return ($otherUnpaidTeams->count() > 0 && $ownUnpaidTeams->count() == 0) ? PaymentStatusValEnum::OTHER : PaymentStatusValEnum::PENDING;
        }
    }

    public function getLeaguePaymentMessage($division, $consumer)
    {
        $paymentStatus = $this->getLeaguePaymentStatus($division, $consumer);
        $message = PaymentStatusEnum::getValue($paymentStatus);
        if ($consumer->ownLeagues($division)) {
            return ($paymentStatus != PaymentStatusValEnum::PAID) ? PaymentStatusEnum::STATUS_CHAIRMAN : PaymentStatusEnum::PAID;
        } else {
            return PaymentStatusEnum::getValue($paymentStatus);
        }
    }

    public function getUnpaidLeagues()
    {
        return DivisionTeam::with(['team.consumer.user', 'division.consumer.user'])->where('season_id', Season::getLatestSeason())
        ->notPaid()->get();
    }

    public function getTeamsSortByUser($user, $division)
    {
        $consumer_id = $user->consumer->id;

        $otherTeams = DivisionTeam::with(['team', 'team.consumer.user', 'division'])
        ->whereHas('team', function ($query) {
            $query->approve();
        })
        ->where('season_id', Season::getLatestSeason())
        ->where('division_id', $division->id)
        ->whereHas('team', function ($query) use ($consumer_id) {
            return $query->where('manager_id', '<>', $consumer_id);
        });

        return DivisionTeam::with(['team', 'team.consumer.user', 'division'])
        ->whereHas('team', function ($query) {
            $query->approve();
        })
        ->where('season_id', Season::getLatestSeason())
        ->where('division_id', $division->id)
        ->whereHas('team', function ($query) use ($consumer_id) {
            return $query->where('manager_id', $consumer_id);
        })
        ->union($otherTeams)
        ->get();
    }

    public function checkPaymentForSocialLeague($id, $division)
    {
        $checkPaymentForSocialLeague = team::join('division_teams', 'division_teams.team_id', '=', 'teams.id')
        ->where('teams.manager_id', $id)
        ->where('division_teams.division_id', $division->id)
        ->get()->first();

        return $checkPaymentForSocialLeague;
    }
}
