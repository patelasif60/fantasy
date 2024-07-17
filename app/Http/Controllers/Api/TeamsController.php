<?php

namespace App\Http\Controllers\Api;

use App\Models\Team;
use App\Models\Pitch;
use App\Models\Player;
use App\Models\Season;
use App\Models\Division;
use App\Enums\YesNoEnum;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\TeamService;
use App\Models\PredefinedCrest;
use Illuminate\Http\JsonResponse;
use App\Services\TransferService;
use App\Services\DivisionService;
use App\Services\TeamLineupService;
use App\Http\Controllers\Controller;
use App\Services\LeaguePaymentService;
use App\Http\Requests\Api\Team\StoreRequest;
use App\Http\Resources\Team as TeamResource;
use App\Jobs\ProcessTeamLineUpCheckAndReset;
use App\Http\Resources\Pitch as PitchResource;
use App\Events\Manager\Divisions\TeamIgnoreEvent;
use App\Events\Manager\Divisions\TeamApprovalEvent;
use App\Http\Requests\Api\TeamBudget\UpdateRequest;
use App\Http\Resources\PredefinedCrest as PredefinedCrestResource;

class TeamsController extends Controller
{
    /**
     * @var TeamService
     */
    protected $service;

    /**
     * @var LeaguePaymentService
     */
    protected $leaguePaymentService;

    /**
     * @var TransferService
     */
    protected $transferService;

    /**
     * @var TeamLineupService
     */
    protected $teamLineupService;

    /**
     * @var DivisionService
     */
    protected $divisionService;


    public function __construct(TeamService $service, LeaguePaymentService $leaguePaymentService, TransferService $transferService, TeamLineupService $teamLineupService, DivisionService $divisionService)
    {
        $this->service = $service;
        $this->transferService = $transferService;
        $this->teamLineupService = $teamLineupService;
        $this->leaguePaymentService = $leaguePaymentService;
        $this->divisionService = $divisionService;
    }

    public function index(Request $request)
    {
        $teams = $request->user()->consumer->teams;

        return response()->json([
            'data' => TeamResource::collection($teams),
        ]);
    }

    public function divisionTeams(Division $division, Request $request)
    {
        $user = $request->user();
        if (! $user->can('view', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $allTeams = $this->leaguePaymentService->getTeamsSortByUser($user, $division);
        $price = (float) $division->getPrice();

        $teams = $allTeams->map(function ($item, $key) use ($division, $price, $user) {
            $team = $item->team;
            $team->isChairmanOrManager = $user->can('isChairmanOrManager', [$division, $team]);
            $team->crest = $team->getCrestImageThumb();
            $team->isPaid = $team->isPaid();
            $team->isStrike = $team->isPaid === 'strike' ? true : false;

            $team->outstanding = (float) $division->getPrize();
            if ($team->isPaid === 'strike') {
                $team->free = $price - $team->outstanding;
            }
            unset($team['teamDivision']);

            return $team;
        });

        $teamApprovals = $this->divisionService->teamApprovals($division)->count();

        $paymentUrl = add_slash_in_url_end(config('app.url')).'manage/division/'.$division->id.'/league/payment/index';

        return response()->json([
            'price' => $price,
            'private_league' => $division->package->private_league,
            'teams' => $teams,
            'teamApprovals' => $teamApprovals,
            'paymentUrl' => $paymentUrl,
        ]);
    }

    public function delete(Division $division, Team $team, Request $request)
    {
        if (! $request->user()->can('isChairmanOrManager', [$division, $team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $delete = $this->service->delete($team);

        if ($delete) {

            return response()->json(['status' => 'success', 'message' => __('messages.data.deleted.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.deleted.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function store(StoreRequest $request, Division $division)
    {
        $user = $request->user();

        if (! $user->can('view', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();
        if (isset($request->crest)) {
            $data['crest_id'] = null;
        }
        $data['manager_id'] = $request->user()->consumer->id;
        $data['email'] = $request->user()->email;
        $data['division_id'] = $division->id;
        $data['is_approved'] = $division->package->private_league == YesNoEnum::NO ? 1 : 0;
        $data['max_free_places'] = $division->package->max_free_places;
        $data['private_league'] = $division->package->private_league;
        if ($request->user()->can('ownLeagues', $division)) {
            $data['is_approved'] = 1;
        }

        $team = $this->service->create($data);

        if ($team) {
            if ($request->get('crest')) {
                $crest = $team->addMediaFromBase64($request->get('crest'));
                $crest->toMediaCollection('crest');
            }

            return response()->json(['status' => 'success', 'message' => __('messages.data.saved.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.saved.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function edit(Team $team, Request $request)
    {
        $user = $request->user();
        $division = $team->teamDivision->first();

        if (! $user->can('isChairmanOrManager', [ $division, $team ])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        return response()->json([
            'data' => new TeamResource($team),
        ]);
    }

    public function update(Request $request, Team $team)
    {
        $user = $request->user();
        $division = $team->teamDivision->first();

        if (! $user->can('isChairmanOrManager', [ $division, $team ])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $request->all();
        if (! $request->has('crest_id') || ! $request->get('crest_id')) {
            $data['crest_id'] = null;
        }

        $teamData = array_replace($team->toArray(), $data);

        $team = $this->service->update(
            $team,
            $teamData
        );

        if ($team) {

            if($request->has('oldpic') && !$request->get('oldpic')) {

                if ($request->get('crest')) {
                    $crest = $team->addMediaFromBase64($request->crest);
                    $crest->toMediaCollection('crest');
                } else {
                    $this->service->crestDestroy($team);
                }
            }

            return response()->json(['status' => 'success', 'message' => __('messages.data.saved.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.saved.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function selectCrest(Request $request)
    {
        $crests = PredefinedCrest::where('is_published', true)->get();

        return response()->json([
            'data' => PredefinedCrestResource::collection($crests),
            'size' => ['width' => 250, 'height' => 250],
            'messages' => __('messages.permission'),
        ]);
    }

    public function selectPitch(Request $request)
    {
        $crests = Pitch::all();

        return response()->json([
            'data' => PitchResource::collection($crests),
        ]);
    }

    public function getRequestList(Division $division, Request $request)
    {
        $user = $request->user();

        if (! $user->can('ownLeagues', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $teams = $this->service->getPendingRequests($division);

        return response()->json([
            'data' => TeamResource::collection($teams),
        ]);
    }

    public function approveTeam(Team $team, Request $request)
    {
        $division = $team->teamDivision->first();

        if (! $request->user()->can('ownLeagues', $division)) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }
        
        $teamTmp = $team;
        $team = $this->service->approveTeam($team);
        // Fire off the event
        $this->service->sendTeamConformationMail($team);
        event(new TeamApprovalEvent($teamTmp, $teamTmp->consumer->user));

        return response()->json(['status' => 'success', 'message' => 'Request Approved successfully!' ], JsonResponse::HTTP_OK);
    }

    public function ignoreTeam(Team $team, Request $request)
    {
        $division = $team->teamDivision->first();

        if (! $request->user()->can('ownLeagues', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $teamTmp = $team;
        $team = $this->service->ignoreTeam($team);

        event(new TeamIgnoreEvent($teamTmp, $teamTmp->consumer->user));

        return response()->json(['status' => 'success', 'message' => 'Request ignored successfully!' ], JsonResponse::HTTP_OK);
    }

    public function lineup(Division $division, Team $team, Request $request)
    {
        $user = $request->user();

        if (! $user->can('view', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $lineup = $this->service->lineup($division, $team);
        unset($lineup['division']);
        unset($lineup['formation']);
        unset($lineup['team']);
        $ownTeam = $user->can('ownLeagues', $division) ? true : $user->can('ownTeam', $team) ? true : false;
        $lineup['supersubs_config'] = config('fantasy_app.supersubs');
        $lineup['ownTeam'] = $ownTeam;
        $lineup['isSupersubDisabled'] = ($lineup['supersub_feature_live'] && ($lineup['enableSupersubs'] && $lineup['allowWeekendChanges']) && ($ownTeam && $lineup['isSupersubDisabled'])) ? true : false;
        $lineup['isSubsDisabled'] = $ownTeam && $lineup['allowWeekendSwap'] ? true : false;
        $lineup['columns'] = $this->divisionService->leagueStandingColumnHideShow($division);

        return $lineup;
    }

    public function getHistoryPlayers(Division $division, Team $team, Request $request)
    {
        $user = $request->user();

        if (! $user->can('view', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $history = $this->service->playerHistory($division, $team);
        $sold = $this->service->soldPlayers($team, $division);
        $columns = $this->divisionService->leagueStandingColumnHideShow($division);

        return response()->json([ 'history' => $history, 'sold' => $sold, 'columns' => $columns ]);
    }

    public function getPlayerStats(Team $team)
    {
        $data = $this->service->getPlayerStats($team);

        return $data;
    }

    public function swapPlayer(Division $division, Team $team, Request $request)
    {
        $lineup_player = $request->get('lineup_player');
        $sub_player = $request->get('sub_player');
        $formation = $request->get('formation');

        $validation = $this->transferService->subsValidation($division, $team, $lineup_player, $sub_player, $formation);

        if(Arr::has($validation, 'status') && Arr::get($validation, 'status') === 'success') {

            $result = $this->teamLineupService->swapPlayer($division, $team, $lineup_player, $sub_player, $formation);

            return response()->json(['status' => 'success', 'message' => Arr::get($result, 'message','')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => Arr::get($validation, 'message','')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function getPlayerStatsBySeason(Team $team, Player $player, Season $season)
    {
        $stats = $this->service->getPlayerStatsBySeason($team, $player, $season);

        return $stats;
    }

    public function teamsBudgetList(Division $division)
    {
        $divisionTeams = $this->service->getDivisionTeamsDetails($division);

        return response()->json($divisionTeams);
    }

    public function teamsBudgetUpdate(Division $division, UpdateRequest $request)
    {
        if (! $request->user()->can('update', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $this->service->teamsBudgetUpdate($division, $request->all());

        if ($data) {

            return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.updated.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
