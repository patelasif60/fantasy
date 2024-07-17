<?php

namespace App\Http\Controllers\Admin;

use JavaScript;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Enums\AgentTransferAfterEnum;
use App\Enums\AuctionTypesEnum;
use App\Enums\DigitalPrizeTypeEnum;
use App\Enums\Division\StatusEnum;
use App\Enums\EventsEnum;
use App\Enums\FormationEnum;
use App\Enums\MoneyBackEnum;
use App\Enums\PositionsEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\YesNoEnum;
use App\Models\Consumer;
use App\Models\Division;
use App\Models\Season;
use App\Models\User;
use App\Services\TeamService;
use App\Services\DivisionService;
use App\Services\InviteService;
use App\Services\PrizePackService;
use App\DataTables\DivisionsDataTable;
use App\Enums\SealedBidDeadLinesEnum;
use App\Enums\TransferAuthorityEnum;
use App\Http\Controllers\Controller;
use App\DataTables\SubDivisionsDataTable;
use App\Http\Requests\Division\StoreRequest;
use App\Http\Requests\Division\UpdateRequest;

class DivisionsController extends Controller
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
     * @var prizePackService
     */
    protected $prizePackService;

    /**
     * DivisionsController constructor.
     *
     * @param DivisionService $service
     */
    public function __construct(DivisionService $service, InviteService $inviteService, TeamService $teamService, PrizePackService $prizePackService)
    {
        $this->service = $service;
        $this->inviteService = $inviteService;
        $this->teamService = $teamService;
        $this->prizePackService = $prizePackService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = StatusEnum::toSelectArray();
        $consumers = [];
        $seasons = Season::orderBy('id','desc')->pluck('name','id');

        return view('admin.divisions.index', compact('consumers', 'statuses','seasons'));
    }

    /**
     * Fetch the divisions data for datatable.
     *
     * @param DivisionsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(DivisionsDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($parentdivision = null)
    {
        $seasonLatest = Season::getLatestSeason();
        // $consumers = $this->service->getConsumers();
        $divisions = $this->service->getDivisions($seasonLatest);
        $packages = $this->service->getPackages();
        $seasonAvailablePackages = Season::find($seasonLatest)->available_packages;
        $allPrizePacks = $this->prizePackService->getAll();
        $leagueType = $this->service->getLeagueType();
        $defaultUser = User::where('email', '=', config('fantasy.default_admin_email'))->first();
        $defaultconsumerId = $defaultUser->consumer->id;
        $defaultName = $defaultUser->first_name.' '.$defaultUser->last_name;

        return view('admin.divisions.create', compact('divisions', 'parentdivision', 'packages', 'seasonAvailablePackages', 'allPrizePacks', 'leagueType', 'defaultconsumerId', 'defaultName'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if ($request['social_id'] > 0) {
            $request['chairman_id'] = $request['social_id'];
        }
        $user = Consumer::find($request['chairman_id']);
        $request['is_viewed_package_selection'] = true;
        $division = $this->service->create($request->all());

        if ($division) {
            $invitation = $this->inviteService->invitation($division);

            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.divisions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Division $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        $season = $division->getSeason();
        $yesNo = YesNoEnum::toSelectArray();
        $auctionTypesEnum = AuctionTypesEnum::toSelectArray();
        $sealedBidDeadLinesEnum = SealedBidDeadLinesEnum::toSelectArray();
        $moneyBackEnum = MoneyBackEnum::toSelectArray();
        $tiePreferenceEnum = TiePreferenceEnum::toSelectArray();
        $formation = FormationEnum::toSelectArray();
        $transferAuthority = TransferAuthorityEnum::toSelectArray();
        $agentTransferAfterEnum = AgentTransferAfterEnum::toSelectArray();
        $digitalPrizeTypeEnum = DigitalPrizeTypeEnum::toSelectArray();
        $consumers = $this->service->getChairman($division); //$this->service->getConsumers();
        $coChairmens = $this->service->getCoChairmen($division);
        $seasons = $this->service->getSeasons();
        $packages = $this->service->getPackagesBySeason($season);
        $divisions = $this->service->getDivisions($season);
        $onlyNoEnum = YesNoEnum::NO;
        $positionsEnum = PositionsEnum::toSelectArray();
        $eventsEnum = EventsEnum::toSelectArray();
        $key = collect([$division->id => $division->id]);
        $divisions = $divisions->diffKeys($key);
        $defaultSeason = '';
        if ($seasons) {
            $defaultSeason = key($seasons);
        }

        $allDivisions = $this->teamService->getDivisions($season);
        $crests = $this->teamService->getPredefinedCrests();
        $pitches = $this->teamService->getPitches();
        $seasonAvailablePackages = Season::find($season)->available_packages;
        $allPrizePacks = $this->prizePackService->getAll();
        $leagueType = $this->service->getLeagueType();
        $selectedLeagueType = $division->package->private_league;
        $defaultUser = User::where('email', '=', config('fantasy.default_admin_email'))->first();
        $defaultconsumerId = $defaultUser->consumer->id;
        $defaultName = $defaultUser->first_name.' '.$defaultUser->last_name;
        $teams = $division->divisionTeams->pluck('name', 'id');
        $isCompetetionStarted = $this->service->checkChampionEuropaGameweekStart();

        JavaScript::put([
            'defaultSeason' => $defaultSeason,
            'division_id' => $division->id,

        ]);

        return view('admin.divisions.edit', compact('division', 'consumers', 'coChairmens', 'divisions', 'seasons', 'defaultSeason', 'packages', 'yesNo', 'auctionTypesEnum', 'sealedBidDeadLinesEnum', 'moneyBackEnum', 'tiePreferenceEnum', 'formation', 'transferAuthority', 'agentTransferAfterEnum', 'digitalPrizeTypeEnum', 'onlyNoEnum', 'positionsEnum', 'eventsEnum', 'allDivisions', 'crests', 'pitches', 'seasonAvailablePackages', 'allPrizePacks', 'leagueType', 'defaultconsumerId', 'defaultName', 'selectedLeagueType', 'teams', 'isCompetetionStarted'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Division $division
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Division $division)
    {
        if ($request['social_id'] > 0) {
            $request['chairman_id'] = $request['social_id'];
            $request['auction_types'] = AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION;
        }
        $dbPackageId = $division->package_id;
        $data = $request->all();
        $data = array_filter($data);
        $data['first_seal_bid_deadline'] = ! is_null(Arr::get($data, 'first_seal_bid_deadline')) ? carbon_set_db_date_time($data['first_seal_bid_deadline']) : null;
        $data['auction_date'] = ! is_null(Arr::get($data, 'auction_date')) ? carbon_set_db_date_time($data['auction_date']) : null;

        $division = $this->service->update(
            $division,
            $data
        );

        if ($data['package_id'] != $dbPackageId) {
            $divisionUid = Division::where('uuid', $division->uuid)->count();
            if ($divisionUid > 1 || $division->is_legacy == 1) {
                $division->refresh();
                $this->service->updateFreePlaceTeam($division);
            }
        }

        if ($division) {
            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('admin.divisions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Divisions $season
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        if ($division->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.divisions.index');
    }

    public function subdivison(Division $division)
    {
        $consumers = $this->service->getConsumers();

        return view('admin.divisions.subdivison', compact('consumers', 'division'));
    }

    public function subdivisons(SubDivisionsDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function searchDivisions(Request $request)
    {
        $search = $request->get('search');

        $divisions =  Division::join('division_teams', 'divisions.id', '=', 'division_teams.division_id')
            ->join('seasons', 'seasons.id', '=', 'division_teams.season_id')
            ->where('divisions.name', 'LIKE', '%'.$search.'%')
            ->selectRaw('divisions.id as id, concat(divisions.name, " (", seasons.name , ")") as text')
            ->limit(100)
            ->groupBy('divisions.id','seasons.name','divisions.name')
            ->get();

        return $divisions;
    }
}
