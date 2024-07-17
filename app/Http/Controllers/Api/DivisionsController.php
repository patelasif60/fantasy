<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Enums\AgentTransferAfterEnum;
use App\Enums\AuctionTypesEnum;
use App\Enums\DigitalPrizeTypeEnum;
use App\Enums\FormationEnum;
use App\Enums\MoneyBackEnum;
use App\Enums\SealedBidDeadLinesEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\TransferAuthorityEnum;
use App\Enums\TransferRoundProcessEnum;
use App\Enums\YesNoEnum;
use App\Http\Controllers\Api\Controller as BaseController;
use App\Http\Requests\Api\Division\StoreRequest;
use App\Http\Requests\Api\Division\UpdateRequest;
use App\Http\Resources\Consumer as ConsumerResource;
use App\Http\Resources\Division as DivisionResource;
use App\Http\Resources\GameWeek as GameWeekResource;
use App\Http\Resources\Season as SeasonResource;
use App\Models\Consumer;
use App\Models\Division;
use App\Models\DivisionPoint;
use App\Models\GameWeek;
use App\Models\Package;
use App\Models\Season;
use App\Models\PrizePack;
use App\Services\DivisionService;
use App\Services\FixtureService;
use App\Services\GameWeekService;
use App\Services\HeadToHeadFixtureService;
use App\Services\InviteService;
use App\Services\TeamService;
use App\Services\TransferRoundService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class DivisionsController extends BaseController
{
    /**
     * @var DivisionService
     */
    protected $service;

    /**
     * @var InviteService
     */
    protected $inviteService;

    /**
     * @var TeamService
     */
    protected $teamService;

    /**
     * @var FixtureService
     */
    protected $fixtureService;

    /**
     * @var GameWeekService
     */
    protected $gameWeekService;

    /**
     * @var HeadToHeadFixtureService
     */
    protected $headToHeadFixtureService;

    /**
     * @var TransferRoundService
     */
    protected $transferRoundService;

    /**
     * DivisionsController constructor.
     *
     * @param DivisionService $service
     */
    public function __construct(DivisionService $service, InviteService $inviteService, FixtureService $fixtureService, HeadToHeadFixtureService $headToHeadFixtureService, GameWeekService $gameWeekService, TeamService $teamService, TransferRoundService $transferRoundService)
    {
        $this->service = $service;
        $this->teamService = $teamService;
        $this->inviteService = $inviteService;
        $this->fixtureService = $fixtureService;
        $this->gameWeekService = $gameWeekService;
        $this->transferRoundService = $transferRoundService;
        $this->headToHeadFixtureService = $headToHeadFixtureService;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $consumer = $user->consumer;
        $divisions = $this->service->getUserLeagues($user);
        $pendingTeams = $divisions->count() ? collect() : $this->teamService->getRequestPendingTeams($consumer);

        return response()->json([
            'data' => DivisionResource::collection($divisions),
            'pendingTeams' => $pendingTeams,
            'messages' => __('messages.leagues_messages'),
        ]);
    }

    public function details(Request $request, Division $division)
    {
        return response()->json([
            'data' => new DivisionResource($division),
        ]);
    }

    public function basic(Request $request, Division $division)
    {
        $user = auth('api')->user();

        if (! $user->can('view', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        return response()->json([
            'data' => $division->auctionBasic($user),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Package $package)
    {
        $data = $request->all();
        $data['chairman_id'] = $request->user()->consumer->id;
        $data['package_id'] = Season::find(Season::getLatestSeason())->default_package_for_existing_user;
        $checkNewUserteam = $this->service->checkNewUserteam($data['chairman_id']) && $this->service->checkNewUserteamPrevious($data['chairman_id']);
        if ($checkNewUserteam) {
            $data['package_id'] = Season::find(Season::getLatestSeason())->default_package;
        }
        $division = $this->service->create($data);
        $invitation = $this->inviteService->invitation($division);

        if ($division) {
            return response()->json([
                'data' => [
                    'division' => $division,
                    'invitation' => $invitation,
                ],
            ]);
        }
    }

    public function edit(\Illuminate\Http\Request $request, Division $division)
    {
        if (! $request->user()->can('view', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $yesNo = YesNoEnum::toSelectArray();
        $auctionTypesEnum = AuctionTypesEnum::toSelectArray();
        $sealedBidDeadLinesEnum = SealedBidDeadLinesEnum::toSelectArray();
        $moneyBackEnum = MoneyBackEnum::toSelectArray();
        $tiePreferenceEnum = TiePreferenceEnum::toSelectArray();
        $formation = FormationEnum::toSelectArray();
        $transferAuthority = TransferAuthorityEnum::toSelectArray();
        $agentTransferAfterEnum = AgentTransferAfterEnum::toSelectArray();
        $digitalPrizeTypeEnum = DigitalPrizeTypeEnum::toSelectArray();
        $consumers = $this->service->getCoChairman($division);
        $onlyNoEnum = YesNoEnum::NO;
        $packages = $this->service->getCurrentSeasonPackages();

        $checkNewUserteam = $this->service->checkNewUserteam($division->chairman_id) && $this->service->checkNewUserteamPrevious($division->chairman_id);
        $divisionUid = Division::where('uuid', $division->uuid)->count();

        $packages = $packages->map(function ($package) use($division, $checkNewUserteam, $divisionUid) {
            
            if($package->free_placce_for_new_user == 'Yes') {
                if($checkNewUserteam) {
                    if($divisionUid == 1 && $division->is_legacy == 0) {
                        $package->price = 0;
                    }
                }
            }

            return $package;
        });

        $packagePrizePacks = $division->package->prize_packs;
        $prizePacks = PrizePack::orderBy('id', 'desc')->get();
        $defaultPackagePrizePack = $division->package->default_prize_pack;

        return response()->json([
            'data' => new DivisionResource($division->load('package', 'coChairmen', 'divisionPoints', 'auctionRounds')),
            'consumers' => ConsumerResource::collection($consumers),
            'packages' => $packages,
            'prizePacks' => $prizePacks,
            'defaultPackagePrizePack' => $defaultPackagePrizePack,
            'yesNo' => $yesNo,
            'auctionTypesEnum' => $auctionTypesEnum,
            'sealedBidDeadLinesEnum' => $sealedBidDeadLinesEnum,
            'moneyBackEnum' => $moneyBackEnum,
            'tiePreferenceEnum' => $tiePreferenceEnum,
            'formation' => $formation,
            'transferAuthority' => $transferAuthority,
            'agentTransferAfterEnum' => $agentTransferAfterEnum,
            'digitalPrizeTypeEnum' => $digitalPrizeTypeEnum,
            'onlyNoEnum' => $onlyNoEnum,
        ]);
    }

    public function update(UpdateRequest $request, Division $division)
    {
        if (! $request->user()->can('update', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $division = $this->service->updateDivision(
            $division,
            $request->all()
        );

        if ($division) {

            $division = new DivisionResource(Division::find($division->id));

            return response()->json(['status' => 'success', 'data' => $division, 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.updated.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function updateDivisionPoint(Request $request, Divisionpoint $divisionpoint)
    {
        if ($divisionpoint->division->package->allow_custom_scoring !== YesNoEnum::YES) {
            return response()->json(['status' => 'error', 'message' => 'Package does not allow custom scoring'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->get('columnValue') >= -10 && $request->get('columnValue') <= 10) {
            $divisionpoint = $this->service->updateDivisionPoint(
                $divisionpoint,
                $request->all()
            );

            if ($divisionpoint) {
                return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
            }

            return response()->json(['status' => 'error', 'message' => __('messages.data.updated.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['status' => 'error', 'message' => 'Value must be between -10 to 10'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Validate the league name if already exists or not in DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateLeagueName(StoreRequest $request)
    {
        $status = $this->service->validateLeagueName($request->get('name'));

        return response()->json([
            'data' => ['status' => $status],
        ]);
    }

    public function infoLeagueStandings(\Illuminate\Http\Request $request, Division $division)
    {
        if (! $request->user()->can('view', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $season = Season::with('gameweeks')->find(Season::getLatestSeason());
        $gameweeks = $season->gameweeks;
        $activeWeekId = $this->service->leagueStandingActiveGameWeek($gameweeks);
        $months = $this->service->getMonths($division);

        $data = $request->all();
        $data['filter'] = 'season';

        $divisionTeams = $this->service->getDivisionLeagueStandingsTeamsScores($division, $data);

        $columns = $this->service->leagueStandingColumnHideShow($division);

        $message = setting('league_info_message');

        return response()->json([
            'teams' => $divisionTeams,
            'season' => new SeasonResource($season),
            'gameweeks' => GameWeekResource::collection($gameweeks),
            'months' => $months,
            'columns' => $columns,
            'activeWeekId' => $activeWeekId,
            'message' => strip_tags($message) ? $message : '',
        ]);
    }

    public function infoLeagueStandingsFilter(Request $request, Division $division)
    {
        if (! $request->user()->can('view', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if ($request->has('filter') && $request->has('linkedLeague') && $request->get('filter') == 'season') {
            
            $divisionTeams = $this->service->getDivisionLeagueStandingsTeamsScores($division, $request->all());

            return response()->json([
                'teams' => $divisionTeams,
            ]);
        }

        if ($request->has('startDate') && $request->has('endDate') && $request->has('linkedLeague')) {

            $validator = Validator::make($request->all(), [
                'startDate' => 'required|date_format:Y-m-d',
                'endDate' => 'required|date_format:Y-m-d',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

            $divisionTeams = $this->service->getDivisionLeagueStandingsTeamsScores($division, $request->all());

            return response()->json([
                'data' => $divisionTeams,
            ]);
        }

        $divisionTeams = $this->service->getDivisionLeagueStandingsTeamsScores($division, $request->all());

        return response()->json([
            'teams' => $divisionTeams,
        ]);
    }

    public function infoFaCupFilter(Request $request, Division $division)
    {
        if (! $request->user()->can('view', $division) && ! $request->user()->can('allowFaCup', $division)) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $allRounds = config('fa-cup.rounds');
        $playedRounds = $this->fixtureService->playedRoundsList($division);
        $currentRound = $this->fixtureService->getCurrentFaCupRound($division);
        $currentRound = $currentRound ? $currentRound->stage : '';
        $divisionTeams = $this->service->getDivisionFaCupTeamsScores($division, $request->all());
        $columns = $this->service->leagueStandingColumnHideShow($division);

        return response()->json([
            'teams' => $divisionTeams,
            'allRounds' => $allRounds,
            'playedRounds' => $playedRounds,
            'currentRound' => $currentRound,
            'columns' => $columns
        ]);
    }

    public function infoHeadToHead(Request $request, Division $division)
    {
        if (! $request->user()->can('allowHeadToHeadChairmanOrManager', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $teamCount = $this->service->adjustSize($division->divisionTeamsCurrentSeason()->approve()->count());
        $gameweeks = $this->gameWeekService->getGameWeekUsingSize($teamCount, $division);
        $divisionTeams = $this->headToHeadFixtureService->getDivisionHeadToHeadTeamsScores($division);
        $activeWeekId = $this->service->headToHeadActiveGameWeek($gameweeks);

        return response()->json([
            'teams' => $divisionTeams,
            'gameweeks' => GameWeekResource::collection($gameweeks),
            'activeWeekId' => $activeWeekId
        ]);
    }

    public function infoHeadToHeadFilter(Request $request, Division $division)
    {
        if (! $request->user()->can('allowHeadToHeadChairmanOrManager', $division)) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            
            return response()->json($validator->errors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $gameweek = GameWeek::find($request->get('id'));
        $divisionTeams = $this->headToHeadFixtureService->getDivisionHeadToHeadTeamsScoresFromGameWeek($division, $gameweek);

        return response()->json([
            'data' => $divisionTeams,
        ]);
    }

    public function updateDivisionsEuropeanCupTeams(Request $request, Division $division)
    {

        /*
        * Just or mobile test else on commented if conidtions
        */
        //if (! $request->user()->can('update', $division) || $this->service->checkChampionEuropaGameweekStart()) {

        if (! $request->user()->can('update', $division) || ! $this->service->checkChampionEuropaGameweekStart()) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if ($request->has('divisionColumn') && $request->has('team')) {
            $validator = Validator::make($request->all(), [
                'divisionColumn' => 'in:champions_league_team,europa_league_team_1,europa_league_team_2',
                'team' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

            $data = $request->all();

            $division = $this->service->updateDivisionChampionEuropaTeam($division, $data);

            if ($division) {
                return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
            }
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function firstApprovedTeam(Request $request, Division $division)
    {
        $team = null;
        if (isset($division) && $division) {
            $user = $request->user();
            $consumer = $user->consumer;
            if ($division->isPostAuctionState()) {
                $team = $consumer->ownFirstApprovedTeamDetails($division);
            }
        }

        return response()->json(['status' => 'success', 'team' => $team], JsonResponse::HTTP_OK);
    }
}
