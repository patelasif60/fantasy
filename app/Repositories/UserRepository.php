<?php

namespace App\Repositories;

use App\Mail\Auth\ChangeMailAddressEmail;
use App\Mail\Auth\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mail;

class UserRepository
{
    public function update($user, $data)
    {
        $oldEmail = $user->email;
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->username = ! empty($data['username']) ? $data['username'] : $user->username;
        $user->email = ! empty($data['email']) ? $data['email'] : $user->email;
        $user->password = ! empty($data['password']) ? Hash::make($data['password']) : $user->password;
        $return = $user->save();

        $data['first_name'] = ucfirst($data['first_name'] ? $data['first_name'] : $data['last_name']);
        if (! empty($data['email']) && $data['email'] != $oldEmail) {
            Mail::to($data['email'])->send(new ChangeMailAddressEmail($data));
            Mail::to($oldEmail)->send(new ChangeMailAddressEmail($data));
        }
        if (! empty($data['password'])) {
            Mail::to($data['email'])->send(new ResetPasswordEmail($data));
        }

        return $return;
    }

    public function getUserConsumer($user)
    {
        return $user->consumer()->count();
    }

    public function saveUserRegistrationId($user, $data)
    {
        $user->push_registration_id = $data['push_registration_id'];

        return $user->save();
    }

    public function getActiveAdmins()
    {
        return User::active()->admins()->get();
    }

    public function getConsumerTeamLeagueExports()
    {
        $userWithTeams = User::role('user')
            ->join('consumers', 'consumers.user_id', '=', 'users.id')
            ->join('teams', 'teams.manager_id', '=', 'consumers.id')
            ->join('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->join('divisions', function ($join) {
                $join->on('divisions.id', '=', 'division_teams.division_id');
                $join->on('divisions.chairman_id', '!=', 'consumers.id');
            })
            ->join('packages', 'packages.id', '=', 'divisions.package_id')
            ->leftJoin('division_co_chairman', function ($join) {
                $join->on('division_co_chairman.division_id', '=', 'divisions.id');
                $join->on('division_co_chairman.co_chairman_id', '=', 'consumers.id');
            })
            ->selectRaw('consumers.id as consumer_id,consumers.favourite_club,
                users.first_name,users.last_name,users.email,teams.id as team_id,divisions.id as league_id,divisions.chairman_id,division_teams.payment_id,division_teams.is_free,packages.name as package_name,divisions.auction_closing_date,divisions.auction_types,IF(divisions.chairman_id = consumers.id, "Yes", "No") as Chairman, IF(division_co_chairman.co_chairman_id = consumers.id, "Yes", "No") as CoChairman,IF(consumers.has_games_news = 1, "Yes", "No") as news_about_game_updates,IF(consumers.has_third_parities = 1, "Yes", "No") as news_from_our_partners,IF(consumers.has_third_parities = 1, "Yes", "No") as news_from_our_partners,IF(division_teams.payment_id IS NULL,IF(division_teams.is_free = 1, "Free", "Not Paid"),"Paid") as paid_status,IF(divisions.auction_closing_date IS NOT NULL,"Post-auction", IF(divisions.auction_date IS NOT NULL AND NOW() >= divisions.auction_date, "In-auction","Pre-auction")) AS league_status,divisions.auction_types as auction_type,DATE_FORMAT(divisions.auction_date, "%m-%d-%Y %H:%i:%s") as auction_date')
            ->get();

        $userAsOnlyChairman = User::role('user')
            ->join('consumers', 'consumers.user_id', '=', 'users.id')
            ->join('divisions', 'divisions.chairman_id', '=', 'consumers.id')
            ->join('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', function ($join) {
                $join->on('teams.id', '=', 'division_teams.team_id');
                $join->on('teams.manager_id', '=', 'consumers.id');
            })
            ->join('packages', 'packages.id', '=', 'divisions.package_id')
            ->leftJoin('division_co_chairman', function ($join) {
                $join->on('division_co_chairman.division_id', '=', 'divisions.id');
                $join->on('division_co_chairman.co_chairman_id', '=', 'consumers.id');
            })
            ->selectRaw('consumers.id as consumer_id,consumers.favourite_club,
                users.first_name,users.last_name,users.email,teams.id as team_id,divisions.id as league_id,divisions.chairman_id,division_teams.payment_id,division_teams.is_free,packages.name as package_name,divisions.auction_closing_date,divisions.auction_types,IF(divisions.chairman_id = consumers.id, "Yes", "No") as Chairman, IF(division_co_chairman.co_chairman_id = consumers.id, "Yes", "No") as CoChairman,IF(consumers.has_games_news = 1, "Yes", "No") as news_about_game_updates,IF(consumers.has_third_parities = 1, "Yes", "No") as news_from_our_partners,IF(consumers.has_third_parities = 1, "Yes", "No") as news_from_our_partners,IF(division_teams.payment_id IS NULL,IF(division_teams.is_free = 1, "Free", "Not Paid"),"Paid") as paid_status,IF(divisions.auction_closing_date IS NOT NULL,"Post-auction", IF(divisions.auction_date IS NOT NULL AND NOW() >= divisions.auction_date, "In-auction","Pre-auction")) AS league_status,divisions.auction_types as auction_type,DATE_FORMAT(divisions.auction_date, "%m-%d-%Y %H:%i:%s") as auction_date')
            ->get();

        $merge = $userWithTeams->concat($userAsOnlyChairman);
        $merge = $merge->groupBy(function ($item) {
            return $item->consumer_id;
        });

        $data = [];
        foreach ($merge as $key => $users) {
            foreach ($users as $usersKey => $value) {
                $tmpData['First name'] = $value->first_name;
                $tmpData['Last name'] = $value->last_name;
                $tmpData['Email address'] = $value->email;
                $tmpData['Team id'] = $value->team_id;
                $tmpData['League id'] = $value->league_id;
                $tmpData['Chairman'] = $value->Chairman;
                $tmpData['Co-Chairman'] = $value->CoChairman;
                $tmpData['News about game updates'] = $value->news_about_game_updates;
                $tmpData['News from our partners'] = $value->news_from_our_partners;
                $tmpData['Paid status'] = $value->paid_status;
                $tmpData['League package'] = $value->package_name;
                $tmpData['League status'] = $value->league_status;
                $tmpData['Auction type'] = $value->auction_type;
                $tmpData['Auction date'] = $value->auction_date;

                $data[] = $tmpData;
            }
        }

        return $data;
    }
}
