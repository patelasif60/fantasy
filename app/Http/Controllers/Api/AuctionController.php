<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Division;
use App\Enums\YesNoEnum;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Enums\AuctionTypesEnum;
use App\Enums\TiePreferenceEnum;
use App\Services\AuctionService;
use App\Services\DivisionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Repositories\NotificationRepository;
use App\Http\Requests\Api\Auction\UpdateRequest;
use App\Http\Resources\Auction as AuctionResource;
use App\Http\Controllers\Api\Controller as BaseController;

class AuctionController extends BaseController
{
    /**
     * @var LeaguePaymentService
     */
    protected $service;

    /**
     * AuctionController constructor.
     */
    public function __construct(DivisionService $service, NotificationRepository $notificationRepository, AuctionService $auctionService)
    {
        $this->service = $service;
        $this->notificationRepository = $notificationRepository;
        $this->auctionService = $auctionService;
    }

    public function edit(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $auctioneerData[] = null;
        $yesNo = YesNoEnum::toSelectArray();
        $auctionTypesEnum = AuctionTypesEnum::toSelectArray();
        $tiePreferenceEnum = TiePreferenceEnum::toSelectArray();

        //For Client comment disbaled this options
        unset($tiePreferenceEnum[TiePreferenceEnum::LOWER_LEAGUE_POSITION_WINS]);
        unset($tiePreferenceEnum[TiePreferenceEnum::HIGHER_LEAGUE_POSITION_WINS]);
        unset($tiePreferenceEnum[TiePreferenceEnum::NO]);
        unset($tiePreferenceEnum[TiePreferenceEnum::EARLIEST_BID_WINS]);

        $managers = $division->divisionTeams->pluck('manager_id');
        $userData = $this->notificationRepository->getUserPushRegistrationIds($managers);
        foreach ($userData as $userDataKey => $userDataValue) {
            $auctioneerData[$userDataKey]['id'] = $userDataValue->id;
            $auctioneerData[$userDataKey]['name'] = $userDataValue->user->first_name.' '.$userDataValue->user->last_name;
        }

        $isAuctionStart = false;
        $isAuctionEntryStart = false;
        if ($division->isInAuctionState()) {
            $isAuctionEntryStart = $this->auctionService->isAuctionEntryStart($division);
            if ($isAuctionEntryStart) {
                $isAuctionStart = true;
            }
        }

        return response()->json([
            'data' => new AuctionResource($division->load('auctionRounds')),
            'yesNo' => $yesNo,
            'auctionTypesEnum' => $auctionTypesEnum,
            'tiePreferenceEnum' => $tiePreferenceEnum,
            'auctioneers'=> $auctioneerData,
            'isAuctionStart' => $isAuctionStart,
            'is_auction_closed' => $division->isPostAuctionState(),
            'messages' => __('messages.auction'),
        ]);
    }

    public function update(UpdateRequest $request, Division $division)
    {
        if (! $request->user()->can('accessAuctionSettings', $division) && $division->isPostAuctionState()) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $validator = Validator::make($request->all(), [
            'auction_types' => 'sometimes',
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

            return response()->json(['status' => 'error', 'message' => 'The given data was invalid.', 'errors' => $validator->errors() ] , JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
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

        $division = $this->service->updateDivisionsAuction($division, $data);

        if ($division) {

            return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.updated.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function reset(Division $division, Request $request)
    {
        
        if (! $request->user()->can('accessAuctionSettings', $division) && $division->isPostAuctionState()) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $division = $this->auctionService->reset($division);
        
        if ($division) {

            return response()->json(['status' => 'success', 'message' => __('messages.data.reset.success')], JsonResponse::HTTP_OK);
        }
    }
}
