<?php

namespace App\Http\Controllers\Manager;

use App\Enums\AuctionTypesEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\YesNoEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Division\Auction\StoreRequest;
use App\Models\Division;
use App\Repositories\NotificationRepository;
use App\Services\AuctionService;
use App\Services\DivisionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use JavaScript;
use Validator;

class AuctionController extends Controller
{
    /**
     * @var divisionService
     */
    protected $divisionService;

    /**
     * @var AuctionService
     */
    protected $auctionService;

    public function __construct(DivisionService $divisionService, NotificationRepository $notificationRepository, AuctionService $auctionService)
    {
        $this->auctionService = $auctionService;
        $this->divisionService = $divisionService;
        $this->notificationRepository = $notificationRepository;
    }

    public function index(Division $division, Request $request)
    {
        if ($division->auction_date && $request->user()->can('isAuctionActive', $division)) {
            if ($division->getOptionValue('auction_types') == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
                return redirect()->route('manage.auction.online.sealed.bid.index', ['division' => $division]);
            }

            if ($division->getOptionValue('auction_types') == AuctionTypesEnum::OFFLINE_AUCTION) {
                return redirect()->route('manage.auction.offline.index', ['division' => $division]);
            }

            if ($division->getOptionValue('auction_types') == AuctionTypesEnum::LIVE_ONLINE_AUCTION) {
                return redirect()->route('manage.live.online.auction.start', ['division' => $division]);
            }
        }

        return view('manager.auction.index', compact('division'));
    }

    public function create(Division $division)
    {
        $this->authorize('accessAuctionSettings', $division);
        
        $auctionDate = '';
        $auctionTime = '12:00:00';
        $liveOnlineAuction = $auctionRoundStartDate = $auctionRoundStartTime = $auctionRoundEndDate = $auctionRoundEndTime = '';

        if ($division->auction_date) {
            $dateTime = explode(' ', get_date_time_in_carbon($division->auction_date));
            $auctionDate = $dateTime[0];
            $auctionTime = $dateTime[1];
        }

        $auctionRoundStartDate = [];
        $auctionRoundStartTime = [];
        $auctionRoundEndDate = [];
        $auctionRoundEndTime = [];
        $division->load('auctionRounds');
        foreach ($division->auctionRounds as $auctionRounds) {
            $auctionRoundStartDateTime = explode(' ', get_date_time_in_carbon($auctionRounds->start));
            $auctionRoundEndDateTime = explode(' ', get_date_time_in_carbon($auctionRounds->end));
            $auctionRoundStartDate[] = $auctionRoundStartDateTime[0];
            $auctionRoundStartTime[] = $auctionRoundStartDateTime[1];

            $auctionRoundEndDate[] = $auctionRoundEndDateTime[0];
            $auctionRoundEndTime[] = $auctionRoundEndDateTime[1];
        }

        $managers = $division->divisionTeams->pluck('manager_id');
        $userData = $this->notificationRepository->getUserPushRegistrationIds($managers);
        $auctioneerData[] = null;
        foreach ($userData as $userDataKey => $userDataValue) {
            $auctioneerData[$userDataKey]['id'] = $userDataValue->id;
            $auctioneerData[$userDataKey]['name'] = $userDataValue->user->first_name.' '.$userDataValue->user->last_name;
        }
        $yesNo = YesNoEnum::toSelectArray();
        $auctionTypesEnum = AuctionTypesEnum::toSelectArray();
        $tiePreferenceEnum = TiePreferenceEnum::toSelectArray();

        //For Client comment disbaled this options
        unset($tiePreferenceEnum[TiePreferenceEnum::LOWER_LEAGUE_POSITION_WINS]);
        unset($tiePreferenceEnum[TiePreferenceEnum::HIGHER_LEAGUE_POSITION_WINS]);
        unset($tiePreferenceEnum[TiePreferenceEnum::NO]);
        unset($tiePreferenceEnum[TiePreferenceEnum::EARLIEST_BID_WINS]);

        JavaScript::put([
            'LIVE_ONLINE_AUCTION' => AuctionTypesEnum::LIVE_ONLINE_AUCTION,
            'ONLINE_SEALED_BIDS_AUCTION' => AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION,
            'OFFLINE_AUCTION' => AuctionTypesEnum::OFFLINE_AUCTION,
            'DATETIMEPICKER' => config('fantasy.datetimepicker.format'),
            'DATEPICKER' => config('fantasy.datetimedatepicker.format'),
            'AUCTION_TYPE' => $division->getOptionValue('auction_types'),
            'SEALBID_FEATURE_LIVE' => config('fantasy.sealbid_feature_live'),
        ]);

        $disable = '';
        $isAuctionEntryStart = false;
        if ($division->isInAuctionState()) {
            $isAuctionEntryStart = $this->auctionService->isAuctionEntryStart($division);
            if ($isAuctionEntryStart) {
                $disable = 'disabled';
            }
        }

        return view('manager.auction.create', compact('division', 'auctionTypesEnum', 'yesNo', 'auctioneerData', 'liveOnlineAuction', 'tiePreferenceEnum', 'disable', 'auctionDate', 'auctionTime', 'auctionRoundStartDate', 'auctionRoundStartTime', 'auctionRoundEndDate', 'auctionRoundEndTime'));
    }

    public function store(Division $division, StoreRequest $request)
    {
        $this->authorize('accessAuctionSettings', $division);

        $validator = Validator::make($request->all(), [
            'auction_types' => 'sometimes|required',
        ]);

        $checkValidation = false;
        if ($request->has('auction_types')) {
            if ($request->get('auction_types') == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
                $checkValidation = true;
            }
        } else {
            if ($division->auction_types == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
                $checkValidation = true;
            }
        }

        if ($checkValidation) {
            $auctionDateCheck = false;
            $auctionDate = '';

            if (! $division->auction_date && $request->has('auction_date')) {
                $auctionDate = Carbon::createFromFormat(config('fantasy.time.format'), $request->get('auction_date').''.$request->get('auction_time'), config('fantasy.date.timezone'));

                $validator->after(function ($validator) use ($auctionDate) {
                    if ($auctionDate->lte(now())) {
                        $validator->errors()->add('auction_date', "The auction date cannot be set before today's date");
                    }
                });
            }

            if ($division->auction_date) {
                $auctionDate = get_date_time_in_carbon($division->auction_date);

                if ($request->has('auction_date')) {
                    $newDate = Carbon::createFromFormat(config('fantasy.time.format'), $request->get('auction_date').''.$request->get('auction_time'));

                    if ($newDate->format('Y-m-d H:i:s') !== $auctionDate->format('Y-m-d H:i:s')) {
                        $validator->after(function ($validator) use ($newDate) {
                            if ($newDate->lte(now()->addHours(1))) {
                                $validator->errors()->add('auction_date', "The auction date cannot be set before today's date");
                            }
                        });
                    }
                }
            }

            $validator->after(function ($validator) use ($request, $auctionDate) {
                $firstDateTime = $auctionDate;
                foreach ($request->get('round_end_date') as $key => $val) {
                    if (($key == 0) && (isset($request->get('round_start_date')[key($val)]) && isset($request->get('round_start_time')[key($val)]))) {
                        $firstDateTime = $request->get('round_start_date')[key($val)].' '.$request->get('round_start_time')[key($val)];
                        $firstDateTime = Carbon::createFromFormat(config('fantasy.time.format'), $firstDateTime);
                    }

                    $start = $val[key($val)].' '.$request->get('round_end_time')[$key][key($val)];
                    $start = Carbon::createFromFormat(config('fantasy.time.format'), $start);
                    if ($firstDateTime->gte($start)) {
                        $validator->errors()->add('round_end_date.'.$key.'.'.key($val), 'The round '.($key + 1).' end date cannot be set before the round '.($key + 1).' start date');
                    }
                    $firstDateTime = $start;
                }
            });
        }

        if ($validator->fails()) {
            return redirect()->route('manage.division.auction.settings', ['division' => $division])
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->all();
        $data['auction_date'] = ! is_null(array_get($request, 'auction_date')) ? carbon_set_db_date_time($request['auction_date'].' '.$data['auction_time']) : $division->auction_date;
        $data['auction_types'] = Arr::get($data, 'auction_types') ? $data['auction_types'] : $division->auction_types;
        $data['manual_bid'] = YesNoEnum::YES;
        if ($request->has('manual_bid')) {
            //$data['manual_bid'] = YesNoEnum::NO;
        }
        $data['allow_passing_on_nominations'] = YesNoEnum::NO;
        if ($request->has('allow_passing_on_nominations')) {
            $data['allow_passing_on_nominations'] = YesNoEnum::YES;
        }

        $data['budget_rollover'] = YesNoEnum::NO;
        if ($request->has('budget_rollover')) {
            $data['budget_rollover'] = YesNoEnum::YES;
        }

        $data['allow_managers_to_enter_own_bids'] = YesNoEnum::NO;
        if ($request->has('allow_managers_to_enter_own_bids')) {
            $data['allow_managers_to_enter_own_bids'] = YesNoEnum::YES;
        }

        $division = $this->divisionService->updateDivisionsAuction($division, $data);

        flash(__('Data saved sucessfully.'))->success();

        return redirect()->route('manage.division.auction.settings', ['division' => $division]);
    }

    public function reset(Division $division, Request $request)
    {
        $this->authorize('update', $division);

        $this->auctionService->reset($division);

        return redirect(route('manage.auction.index', ['division' => $division]));
    }

    public function pendingPayment(Division $division)
    {
        return view('manager.auction.pendingpayment', compact('division'));
    }

    public function pdfdownloads(Division $division)
    {
        $auctionPackPdfDownload = $this->auctionService->auctionPackPdfDownload($division);

        return view('manager.auction.pdfdownloads', compact('division', 'auctionPackPdfDownload'));
    }
}
