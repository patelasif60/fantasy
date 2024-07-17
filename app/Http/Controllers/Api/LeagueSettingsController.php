<?php

namespace App\Http\Controllers\Api;

use Validator;
use Carbon\Carbon;
use App\Models\Division;
use App\Enums\YesNoEnum;
use Illuminate\Support\Arr;
use App\Enums\MoneyBackEnum;
use Illuminate\Http\Request;
use App\Enums\TiePreferenceEnum;
use App\Services\DivisionService;
use Illuminate\Http\JsonResponse;
use App\Enums\TransferAuthorityEnum;
use App\Http\Controllers\Controller;
use App\Enums\AgentTransferAfterEnum;
use App\Enums\TransferRoundProcessEnum;
use App\Services\TransferRoundService;
use App\Enums\SealedBidDeadLinesEnum;
use App\Services\OnlineSealedBidTransferService;
use App\Http\Resources\TransferRound as TransferRoundResource;
use App\Http\Requests\Division\Setting\StoreRequest as StoreRequest;

class LeagueSettingsController extends Controller
{
    protected $service;

    protected $transferRoundService;

    public function __construct(DivisionService $service, TransferRoundService $transferRoundService)
    {
        $this->service = $service;
        $this->transferRoundService = $transferRoundService;
    }

    public function package(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division) || $request->user()->can('managerHasPaidTeam', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'package_id' => 'required|integer',
        ]);

        if ($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => 'The given data was invalid.', 'errors' => $validator->errors() ] , JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $dbPackageId = $division->package_id;
        
        $division = $this->service->updatePackage($division, $data, $dbPackageId);

        if (Arr::has($data,'package_id') && $data['package_id'] != $dbPackageId) {
            $division = Division::find($division->id);
            $this->service->updateFreePlaceTeam($division);
        }

        return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
    }

    public function prizepack(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division) || $request->user()->can('managerHasPaidTeam', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'prize_pack_id' => 'required|integer',
        ]);

        if ($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => 'The given data was invalid.', 'errors' => $validator->errors() ] , JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $division = $this->service->updatePrizePack($division, $data);

        return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
    }

    public function league(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'package_id' => 'sometimes|required',
        ]);

        if ($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => 'The given data was invalid.', 'errors' => $validator->errors() ] , JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $request->all();
        $chairman_id = $division->chairman_id;
        $dbPackageId = $division->package_id;
        $division = $this->service->updateDivisionsLeague($division, $data);

        if (!$request->user()->can('packageDisabled', $division)) {
            if (Arr::has($data,'package_id') && $data['package_id'] != $dbPackageId) {
                $division->refresh();
                $this->service->updateFreePlaceTeam($division);
            }
        }

        $is_chairman_changed = false;
        if ($chairman_id != $data['chairman_id']) {
            $is_chairman_changed = true;
        }

        return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success'), 'is_chairman_changed' => $is_chairman_changed ], JsonResponse::HTTP_OK);
    }

    public function squadAndFormation(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division)) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        // $isPostAuctionState = $division->isPostAuctionState();
        // $defaultMaxPlayerEachClub = $division->getOptionValue('default_max_player_each_club');

        $validator = Validator::make($data, [
            'default_squad_size' => 'nullable|numeric|min:11|max:18',
            'default_max_player_each_club' => 'nullable|numeric|min:1|max:5',
        ],[
            'default_squad_size.min' => 'Please enter a value greater than or equal to :min',
            'default_squad_size.max' => 'Please enter a value less than or equal to :max',
            'default_max_player_each_club.max' => 'Please enter a value less than or equal to :max',
            'default_max_player_each_club.min' => 'After auction, Club quota can only be increased.',
        ]);

        if ($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => 'The given data was invalid.', 'errors' => $validator->errors() ] , JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $division = $this->service->updateDivisionsSquadAndFormations($division, $data);

        if ($division) {
            return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
        } else {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function pointsSetting(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division)) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $validate_array = [];
        foreach ($request->get('points') as $eventKey => $eventVal) {
            foreach ($eventVal as $positionKey => $positionValue) {
                $validate_array['points.'.$eventKey.'.'.$positionKey] = 'nullable|numeric|min:-10|max:10';
            }
        }

        $validator = Validator::make($request->all(), $validate_array);

        if ($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => 'The given data was invalid.', 'errors' => $validator->errors() ] , JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $request->all();
        $division = $this->service->updateDivisionsPoints($division, $data);

        if ($division) {
            return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
        } else {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function transferSettings(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division) || !$division->isPostAuctionState()) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $division->seal_bids_budget = $division->getOptionValue('seal_bids_budget');
        $division->enable_free_agent_transfer = $division->getOptionValue('enable_free_agent_transfer');
        $division->free_agent_transfer_authority = $division->getOptionValue('free_agent_transfer_authority');
        $division->free_agent_transfer_after = $division->getOptionValue('free_agent_transfer_after');
        $division->season_free_agent_transfer_limit = $division->getOptionValue('season_free_agent_transfer_limit');
        $division->monthly_free_agent_transfer_limit = $division->getOptionValue('monthly_free_agent_transfer_limit');
        $division->seal_bid_deadline_repeat = $division->getOptionValue('seal_bid_deadline_repeat');
        $division->max_seal_bids_per_team_per_round = $division->getOptionValue('max_seal_bids_per_team_per_round');
        $division->seal_bid_increment = $division->getOptionValue('seal_bid_increment');
        $division->seal_bid_minimum = $division->getOptionValue('seal_bid_minimum');
        $division->money_back = $division->getOptionValue('money_back');

        $unprocessRoundCount = $this->transferRoundService->unprocessRoundCount($division);
        $sealedBidDeadLinesEnum = SealedBidDeadLinesEnum::toSelectArray();
        $tiePreferenceEnum = TiePreferenceEnum::toSelectArray();
        $agentTransferAfterEnum = AgentTransferAfterEnum::toSelectArray();
        $moneyBackEnum = MoneyBackEnum::toSelectArray();
        $isPostAuctionState = $division->isPostAuctionState();
        $yesNo = YesNoEnum::toSelectArray();
        $transferAuthority = TransferAuthorityEnum::toSelectArray();
        $dateFormat = config('fantasy.datetimedatepicker.format');

        return response()->json([
            'division' => $division,
            'package' => $division->package,
            'transferRounds' => TransferRoundResource::collection($division->transferRounds),
            'sealedBidDeadLinesEnum' => $sealedBidDeadLinesEnum,
            'tiePreferenceEnum' => $tiePreferenceEnum,
            'agentTransferAfterEnum' => $agentTransferAfterEnum,
            'moneyBackEnum' => $moneyBackEnum,
            'yesNo' => $yesNo,
            'transferAuthority' => $transferAuthority,
            'isPostAuctionState' => $isPostAuctionState,
            'dateFormat' => $dateFormat,
            'unprocessRoundCount' => $unprocessRoundCount,
            'messages' => __('messages.transfer_settings'),
        ]);
    }

    public function transferSettingsUpdate(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division) || !$division->isPostAuctionState()) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        if ($division->isPostAuctionState()) {

            //For transfer validation we use this class StoreRequestTransfer
            if ($division->isPostAuctionState()) {
                $validator = Validator::make($request->all(), [
                    'season_free_agent_transfer_limit' => 'nullable|numeric',
                ]);

                if ($validator->fails()) {

                    return response()->json(['status' => 'error', 'message' => 'The given data was invalid.', 'errors' => $validator->errors() ] , JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
                }

                $transferRounds = $division->transferRounds;
                $firstRound = $transferRounds->first();
                $allRounds = $transferRounds->keyBy('id');
                $roundCount = 0;
                $validator->after(function ($validator) use ($request, $firstRound, $division, $allRounds, $roundCount) {
                    $firstDateTime = ($firstRound && $firstRound->is_process == TransferRoundProcessEnum::PROCESSED) ? get_date_time_in_carbon($firstRound->start) : now(config('fantasy.date.timezone'));
                    foreach ($request->get('round_end_date') as $key => $val) {
                        $start = $val[key($val)].' '.$request->get('round_end_time')[$key][key($val)];
                        $start = Carbon::createFromFormat(config('fantasy.time.format'), $start, config('fantasy.time.timezone'));

                        $dbRound = $allRounds->get(key($val), null);
                        $isProcess = $dbRound ? $dbRound->is_process : TransferRoundProcessEnum::UNPROCESSED;

                        if ($isProcess == TransferRoundProcessEnum::UNPROCESSED) {
                            $roundCount = $roundCount + 1;
                        }

                        if ($roundCount > 1) {
                            $validator->errors()->add('round_end_date.'.$key.'.'.key($val), 'You cannot add more than one round.');
                        }

                        if ($division->package->allow_seal_bid_deadline_repeat == 'No' && $isProcess === TransferRoundProcessEnum::UNPROCESSED) {
                            if ($firstDateTime->gte($start) || $firstDateTime->diffInMonths($start) <= 0) {
                                $validator->errors()->add('round_end_date.'.$key.'.'.key($val), 'The round '.($key + 1).' end date cannot be set before the round '.($key + 1).' start date or end date should be one month apart');
                            }
                        } else {
                            if ($firstDateTime->gte($start) && $isProcess === TransferRoundProcessEnum::UNPROCESSED) {
                                $validator->errors()->add('round_end_date.'.$key.'.'.key($val), 'The round '.($key + 1).' end date cannot be set before the round '.($key + 1).' start date');
                            }
                        }
                        $firstDateTime = $start;
                    }
                });

                if ($validator->fails()) {

                    return response()->json(['status' => 'error', 'message' => 'The given data was invalid.', 'errors' => $validator->errors() ] , JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
                }
            }

            $newTiePreference = Arr::has($data, 'tie_preference') ? $data['tie_preference'] : $division->getOptionValue('tie_preference');
            $oldTiePreference = $division->getOptionValue('tie_preference');

            $division = $this->service->updateDivisionsTransfer($division, $data);

            if ($division->isPostAuctionState()) {
                $this->transferRoundService->updateRoundManually($division, $data);

                $activeRound = $this->transferRoundService->getActiveRound($division);

                if (Arr::has($data, 'tie_preference')) {
                    if ($activeRound && ($newTiePreference && $oldTiePreference != $newTiePreference)) {
                        $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);
                        $onlineSealedBidTransferService->transferRoundTiePreference($division, $newTiePreference, $activeRound);
                    }
                }
            }

            return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
    }

    public function europeanCups(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division)) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $division = $this->service->updateDivisionsEuropeanCups($division, $data);

        return response()->json(['status' => 'success', 'message' => __('messages.data.saved.success')], JsonResponse::HTTP_OK);
    }
}
