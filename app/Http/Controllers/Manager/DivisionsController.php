<?php

namespace App\Http\Controllers\Manager;

use App\Enums\AgentTransferAfterEnum;
use App\Enums\AuctionTypesEnum;
use App\Enums\EuropeanPhasesNameEnum;
use App\Enums\EventsEnum;
use App\Enums\FormationEnum;
use App\Enums\MoneyBackEnum;
use App\Enums\PositionsEnum;
use App\Enums\SealedBidDeadLinesEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\TransferAuthorityEnum;
use App\Enums\TransferRoundProcessEnum;
use App\Enums\YesNoEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Division\Manager\StoreRequest;
use App\Http\Requests\Division\Setting\StoreRequest as StoreRequestTransfer;
use App\Models\Auction;
use App\Models\Division;
use App\Models\Fixture;
use App\Models\GameWeek;
use App\Models\InviteCode;
use App\Models\Package;
use App\Models\PrizePack;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;
use App\Repositories\NotificationRepository;
use App\Services\CustomCupFixtureService;
use App\Services\PastWinnerHistoryService;
use App\Services\DivisionService;
use App\Services\FixtureService;
use App\Services\GameWeekService;
use App\Services\HeadToHeadFixtureService;
use App\Services\InviteService;
use App\Services\LeaguePaymentService;
use App\Services\OnlineSealedBidTransferService;
use App\Services\ProcupFixtureService;
use App\Services\SealedBidTransferService;
use App\Services\TeamService;
use App\Services\TransferRoundService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Session;

class DivisionsController extends Controller
{
    const PAGINATE_SEARCH = 10;
    /**
     * @var DivisionService
     */
    protected $service;

    /**
     * @var InviteService
     */
    protected $inviteService;

    /**
     * @var ProCupService
     */
    protected $proCupService;

    /**
     * @var customCupFixtureService
     */
    protected $customCupFixtureService;

    /**
     * @var TeamService
     */
    protected $teamService;

    /**
     * @var FixtureService
     */
    protected $fixtureService;

    /**
     * @var HeadToHeadFixtureService
     */
    protected $headToHeadFixtureService;

    /**
     * @var GameWeekService
     */
    protected $gameWeekService;

    /**
     * @var GameWeekService
     */
    protected $leaguePaymentService;

    /**
     * @var TransferRoundService
     */
    protected $transferRoundService;

    /**
     * @var NotificationRepository
     */
    protected $notificationRepository;

    /**
     * DivisionsController constructor.
     *
     * @param DivisionService $service
     */
    public function __construct(DivisionService $service, InviteService $inviteService, TeamService $teamService, FixtureService $fixtureService, HeadToHeadFixtureService $headToHeadFixtureService, GameWeekService $gameWeekService, ProcupFixtureService $proCupService, LeaguePaymentService $leaguePaymentService, CustomCupFixtureService $customCupFixtureService, TransferRoundService $transferRoundService, NotificationRepository $notificationRepository)
    {
        $this->service = $service;
        $this->inviteService = $inviteService;
        $this->teamService = $teamService;
        $this->proCupService = $proCupService;
        $this->fixtureService = $fixtureService;
        $this->headToHeadFixtureService = $headToHeadFixtureService;
        $this->gameWeekService = $gameWeekService;
        $this->leaguePaymentService = $leaguePaymentService;
        $this->customCupFixtureService = $customCupFixtureService;
        $this->transferRoundService = $transferRoundService;
        $this->notificationRepository = $notificationRepository;
    }

    public function index(Request $request)
    {
        $divisions = $this->service->getUserLeagues($request->user());

        if ($divisions->count() > 0) {
            return redirect(route('manage.division.info', ['division' => $divisions->first()]));
        }

        return redirect(route('manage.division.package.selection'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateLeagueName(Request $request)
    {
        return $this->service->validateLeagueName($request->get('name'));

        // $division = Division::where('name', $request->get('name'));

        // if ($division->count() === 0) {
        //     return 'true';
        // }

        // return 'false';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selection()
    {
        JavaScript::put([
            'uniqueLeagueUrl' => route('manager.unique.league.check'),
        ]);

        $auctions = Auction::all();
        $packages = Package::where('private_league', YesNoEnum::YES)->get();
        $seasonAvailablePackages = Season::find(Season::getLatestSeason())->available_packages;
        $social_league = Package::where('name', 'Social League')->first();

        return view('manager.divisions.package_selection', compact('auctions', 'packages', 'social_league', 'seasonAvailablePackages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(\Illuminate\Http\Request $request)
    {
        $user = $request->user();
        $package = $this->service->getUserPackage($user);

        return view('manager.divisions.create_league', compact('user', 'package'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(\Illuminate\Http\Request $request, Division $division)
    {
        return view('manager.divisions.edit_league', compact('division'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateName(\Illuminate\Http\Request $request, Division $division)
    {
        $division = $this->service->updateName($division, $request->all());
        if ($division) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();

            return redirect()->back();
        }

        return redirect(route('manage.division.invite.managers', ['division' => $division]));
        // return view('manager.divisions.edit_league', compact('division'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDivision(Division $division)
    {
        $user = auth()->user();
        $package = $this->service->getUserPackage($user);

        return view('manager.divisions.create_league', compact('user', 'package', 'division'));
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
        $code = $invitation->code;

        if ($division) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();

            return redirect()->back();
        }

        return redirect(route('manage.division.invite.managers', ['division' => $division]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDivision(StoreRequest $request, Division $division, Package $package)
    {
        $data = $request->all();
        $data['chairman_id'] = $request->user()->consumer->id;
        $data['package_id'] = $package->id;
        $data['email'] = $request->user()->email;
        if ($request->user()->can('ownLeagues', $division)) {
            $data['parent_division_id'] = $division->id;
        }

        $newDivision = $this->service->create($data);
        $invitation = $this->inviteService->invitation($newDivision);
        $code = $invitation->code;

        if ($newDivision) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();

            return redirect()->back();
        }

        return redirect(route('manage.division.invite.managers', ['division' => $newDivision]));
    }

    /**
     * Display long description of the specified package for division.
     *
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function description(Package $package)
    {
        return view('manager.divisions.package.description', compact('package'));
    }

    public function getInvitationDetails(Request $request, $code)
    {
        $invitation = $this->service->getInvitationDetails($code);
        if (! $request->user()->can('checkMaxTeamsQuota', $invitation->division)) {
            flash(__('messages.divisions.max_team'))->error()->important();

            return redirect(route('landing'));
        }

        return redirect(route('manage.division.create.team', ['division' => $invitation->division->id, 'via=invite']));
    }

    public function joinNewLeague(Request $request)
    {
        return view('manager.divisions.join_new_league');
    }

    public function joinDivision(Request $request)
    {
        $data = $request->all();
        if (isset($data['invitation_code']) && $data['invitation_code'] != '') {
            $invitation = InviteCode::where('code', $data['invitation_code'])->first();
            if (! $request->user()->can('checkMaxTeamsQuota', $invitation->division)) {
                flash(__('messages.divisions.max_team'))->error()->important();

                return redirect(route('landing'));
            }
            $divisionId = $invitation->division_id;
        } else {
            $divisionId = $data['division_id'];
        }

        if ($request->ajax()) {
            return ['success' => true, 'redirectTo' => route('manage.division.create.team', ['division' => $divisionId])];
        }

        return redirect(route('manage.division.create.team', ['division' => $divisionId, 'via=invite']));
    }

    public function enterCode()
    {
        return view('manager.divisions.enter_invitation_code');
    }

    public function checkLeagueByCode(Request $request)
    {
        $division = InviteCode::where('code', $request->get('invitation_code'));

        if ($division->count() === 1) {
            return 'true';
        }

        return 'false';
    }

    public function searchLeague(Request $request)
    {
        if (! empty($request->get('invitation_code'))) {
            return $this->joinDivision($request);
        } elseif ($request->has('search_league')) {
            return $this->searchLeagueResults($request);
        }
    }

    protected function searchLeagueResults(Request $request)
    {
        $search = '%'.$request->search_league.'%';

        $allDivisions = Division::with(['package',
            'consumer' => function ($query) use ($search) {
                $query->with('user');
            },
        ])
                ->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', $search)
                        ->orWhereHas('consumer', function ($qry) use ($search) {
                            $qry->whereHas('user', function ($q) use ($search) {
                                $q->where('first_name', 'LIKE', $search)
                                ->orWhere('last_name', 'LIKE', $search);
                            });
                        });
                })
                ->get();

        $url = route('manage.league.search.league', ['search_league'=>$request->search_league]);

        $divisions = paginate_collection($allDivisions->reject(function ($value, $key) {
            if ($value->package->maximum_teams != null) {
                return $value->divisionTeams->count() >= $value->package->maximum_teams;
            }
        }), self::PAGINATE_SEARCH, $url);

        return view('manager.divisions.search_league_results', compact('divisions'));
    }

    public function leagueIndex(Request $request, Division $division, $role = 'chairman')
    {
        $request->session()->put('league.role', $role);
        if ($role == 'chairman' && $division->is_viewed_package_selection == false) {
            return redirect()->route('manage.division.package.change', ['division' => $division]);
        }

        return redirect()->route('manage.division.info', ['division' => $division]);
    }

    public function leagueSettings(Division $division)
    {
        $this->authorize('update', $division);
        $isEuropeanTournamentAvailable = $this->service->checkEuropeanTournamentAvailable($division);

        return view('manager.divisions.league_settings', compact('division', 'isEuropeanTournamentAvailable'));
    }

    public function leagueSettingsEdit(Division $division, $name)
    {
        $this->authorize('ownLeagues', $division);

        $yesNo = YesNoEnum::toSelectArray();
        $auctionTypesEnum = AuctionTypesEnum::toSelectArray();
        $sealedBidDeadLinesEnum = SealedBidDeadLinesEnum::toSelectArray();
        $moneyBackEnum = MoneyBackEnum::toSelectArray();
        $tiePreferenceEnum = TiePreferenceEnum::toSelectArray();
        $formation = FormationEnum::toSelectArray();
        $transferAuthority = TransferAuthorityEnum::toSelectArray();
        $agentTransferAfterEnum = AgentTransferAfterEnum::toSelectArray();
        $onlyNoEnum = YesNoEnum::NO;
        $positionsEnum = PositionsEnum::toSelectArray();
        $eventsEnum = EventsEnum::toSelectArray();

        if ($name == 'package') {

            if (auth()->user()->can('packageDisabled', $division)) {

                return abort(401);
            }

            $packages = Package::where('private_league', YesNoEnum::YES)->get();
            $seasonAvailablePackages = Season::find(Season::getLatestSeason())->available_packages;
            array_push($seasonAvailablePackages, $division->package_id);
            $checkNewUserteam = $this->service->checkNewUserteam($division->chairman_id) && $this->service->checkNewUserteamPrevious($division->chairman_id);
            $divisionUid = Division::where('uuid', $division->uuid)->count();

            return view('manager.divisions.settings.'.$name.'', compact('division', 'packages', 'seasonAvailablePackages', 'checkNewUserteam', 'divisionUid'));
        }

        if ($name == 'prizepack') {
            
            if (auth()->user()->can('packageDisabled', $division)) {

                return abort(401);
            }

            $packagePrizePacks = $division->package->prize_packs;
            $prizePacks = PrizePack::whereIn('id', $packagePrizePacks)->orderBy('id', 'desc')->get();
            $defaultPackagePrizePack = $division->package->default_prize_pack;

            return view('manager.divisions.settings.'.$name.'', compact('division', 'prizePacks', 'defaultPackagePrizePack'));
        }

        if ($name == 'league') {

            $consumers = $this->service->getCoChairman($division);
            $packages = Package::where('private_league', YesNoEnum::YES)->get();
            $seasonAvailablePackages = Season::find(Season::getLatestSeason())->available_packages;

            return view('manager.divisions.settings.'.$name.'', compact('division', 'packages', 'consumers', 'seasonAvailablePackages'));
        }

        if ($name == 'squad_and_formations') {

            JavaScript::put([
                'isPostAuctionState' => $division->isPostAuctionState(),
                'defaultMaxPlayerEachClub' => $division->getOptionValue('default_max_player_each_club'),
            ]);

            return view('manager.divisions.settings.'.$name.'', compact('division', 'formation', 'yesNo', 'onlyNoEnum'));
        }

        if ($name == 'transfer') {
            
            if (!$division->isPostAuctionState()) {

                return abort(401);
            }

            $deadlineRepeat = SealedBidDeadLinesEnum::DONTREPEAT;
            $transferRounds = $division->transferRounds;
            $unprocessRoundCount = $this->transferRoundService->unprocessRoundCount($division);

            $isRoundProcessed = false;
            if ($transferRounds) {
                $sealedBidTransferService = app(SealedBidTransferService::class);
                $isRoundProcessed = $sealedBidTransferService->isRoundProcessed($transferRounds->last());
            }

            JavaScript::put([
                'isPostAuctionState' => $division->isPostAuctionState(),
                'deadlineRepeat' => SealedBidDeadLinesEnum::DONTREPEAT,
                'deadlineEveryMonth' => SealedBidDeadLinesEnum::EVERYMONTH,
                'deadlineFortNight' => SealedBidDeadLinesEnum::EVERYFORTNIGHT,
                'deadlineEveryWeek' => SealedBidDeadLinesEnum::EVERYWEEK,
                'dateFormat' => config('fantasy.datetimedatepicker.format'),
                'unprocessRoundCount' => $unprocessRoundCount,
            ]);

            return view('manager.divisions.settings.'.$name.'', compact('division', 'yesNo', 'transferAuthority', 'agentTransferAfterEnum', 'sealedBidDeadLinesEnum', 'moneyBackEnum', 'tiePreferenceEnum', 'deadlineRepeat', 'transferRounds', 'unprocessRoundCount', 'isRoundProcessed'));
        }

        if ($name == 'points_setting') {

            return view('manager.divisions.settings.'.$name.'', compact('division', 'onlyNoEnum', 'positionsEnum', 'eventsEnum'));
        }

        if ($name == 'european_cups') {

            $isStart = $this->service->checkChampionEuropaGameweekStart();
            $teams = [];
            foreach ($division->divisionTeams as $key => $value) {
                $teams[$value->id] = $value->name;
            }

            return view('manager.divisions.settings.'.$name.'', compact('division', 'teams', 'isStart'));
        }

        return redirect()->route('manage.division.settings', ['division' => $division]);
    }

    public function leagueSettingsUpdate(Division $division, $name, StoreRequestTransfer $request)
    {
        $this->authorize('ownLeagues', $division);

        $data = $request->all();

        if ($name == 'package') {

            if (auth()->user()->can('packageDisabled', $division)) {

                return abort(401);
            }

            $dbPackageId = $division->package_id;
            $division = $this->service->updatePackage($division, $data, $dbPackageId);
            if (Arr::has($data,'package_id') && $data['package_id'] != $dbPackageId) {
                $division = Division::find($division->id);
                $this->service->updateFreePlaceTeam($division);
            }

            if ($division->package->prize_packs) {

                return redirect(route('manage.division.settings.edit', ['division' => $division, 'name' => 'prizepack']));
            }
        }

        if ($name == 'prizepack') {

            if (auth()->user()->can('packageDisabled', $division)) {

                 return abort(401);
            }

            $division = $this->service->updatePrizePack($division, $data);
        }

        if ($name == 'league') {

            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'package_id' => 'sometimes|required',
            ]);

            $chairman_id = $division->chairman_id;
            $dbPackageId = $division->package_id;
            $division = $this->service->updateDivisionsLeague($division, $data);

            if (!auth()->user()->can('packageDisabled', $division)) {
                if (Arr::has($data,'package_id') && $data['package_id'] != $dbPackageId) {
                    $division = Division::find($division->id);
                    $this->service->updateFreePlaceTeam($division);
                }
            }

            if ($chairman_id != $data['chairman_id']) {
                return redirect()->route('frontend');
            }
        }

        if ($name == 'squad_and_formations') {

            $validatedData = $request->validate([
                'default_squad_size' => 'nullable|numeric|min:11|max:18',
                'default_max_player_each_club' => 'nullable|numeric|min:1',
            ]);

            $division = $this->service->updateDivisionsSquadAndFormations($division, $data);
        }

        if ($name == 'transfer') {

            if (!$division->isPostAuctionState()) {

                return abort(401);
            }

            $validator = Validator::make($request->all(), [
                'season_free_agent_transfer_limit' => 'nullable|numeric',
            ]);

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
                return redirect()->route('manage.division.settings.edit', ['division' => $division, 'name' => 'transfer'])
                        ->withErrors($validator)
                        ->withInput();
            }

            $newTiePreference = Arr::has($data, 'tie_preference') ? $data['tie_preference'] : $division->getOptionValue('tie_preference');
            $oldTiePreference = $division->getOptionValue('tie_preference');
            $division = $this->service->updateDivisionsTransfer($division, $data);
            $this->transferRoundService->updateRoundManually($division, $data);
            $activeRound = $this->transferRoundService->getActiveRound($division);
            if (Arr::has($data, 'tie_preference')) {
                if ($activeRound && ($newTiePreference && $oldTiePreference != $newTiePreference)) {
                    $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);
                    $onlineSealedBidTransferService->transferRoundTiePreference($division, $newTiePreference, $activeRound);
                }
            }
        }

        if ($name == 'points_setting') {
            $validate_array = [];
            foreach ($request->get('points') as $eventKey => $eventVal) {
                foreach ($eventVal as $positionKey => $positionValue) {
                    $validate_array['points.'.$eventKey.'.'.$positionKey] = 'nullable|numeric|min:-10|max:10';
                }
            }

            $validatedData = $request->validate($validate_array);
            $division = $this->service->updateDivisionsPoints($division, $data);
        }

        if ($name == 'european_cups') {
            $division = $this->service->updateDivisionsEuropeanCups($division, $data);
        }

        if ($division) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('manage.division.settings', ['division' => $division]);
    }

    public function leagueInfo(Request $request, Division $division)
    {
        if (Session::has('linkedLeague')) {
            Session::forget('linkedLeague');
        }

        if (! $division->isPostAuctionState()) {

            return redirect(route('manage.division.payment.index', ['division' => $division, 'type'=>'league']));
        }

        $consumer = $request->user()->consumer->id;
        $championLeague = $this->service->isCompetition($division, $consumer, EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE);
        $europaLeague = $this->service->isCompetition($division, $consumer, EuropeanPhasesNameEnum::EUROPA_LEAGUE);

        $team_approvals = $this->service->teamApprovals($division);
        $userHasProcupFixture = $this->proCupService->getPhases($division, $consumer)->count();
        $customCups = $this->customCupFixtureService->getCustomCups($division, $request->user()->consumer);

        $season = Season::with('gameweeks')->find(Season::getLatestSeason());
        $gameweeks = $season->gameweeks;
        $activeWeekId = $this->service->leagueStandingActiveGameWeek($gameweeks);

        $events = EventsEnum::toArray();
        $columns = $this->service->leagueStandingColumnHideShow($division);
        $months = $this->service->getMonths($division);
        $hallFameData = $this->service->getHallFameData($division);
        $leagueTitle = $this->service->getLeagueTitleData($division);

        $leagueTitleByTeamId = [];
        $leagueTitleByName = [];
        foreach ($leagueTitle as $title) {
            if(Arr::has($leagueTitleByTeamId, $title->team_id)) {
                $leagueTitleByTeamId[$title->team_id] = $leagueTitleByTeamId[$title->team_id] + $title->titles;
            } else {
                $leagueTitleByTeamId[$title->team_id] = $title->titles;
            }

            if(Arr::has($leagueTitleByName, $title->name)) {
                $leagueTitleByName[$title->name] = $leagueTitleByName[$title->name] + $title->titles;
            } else {
                $leagueTitleByName[$title->name] = $title->titles;
            }
        }
        
        JavaScript::put([
            'columns' => $columns,
            'events' => $events,
            'userIsChairman' => auth()->user()->consumer->ownLeagues($division),
            'hallFameData' => $hallFameData,
            'imgUrl'=> asset('/img/leagueicon'),
            'leagueTitle' => $leagueTitleByTeamId,
            'leagueTitleName' => $leagueTitleByName,
        ]);

        return view('manager.divisions.league_info', compact('division', 'team_approvals', 'userHasProcupFixture', 'championLeague', 'europaLeague', 'customCups', 'months', 'gameweeks', 'activeWeekId'));
    }

    public function infoLeagueStandingsFilter(Request $request, Division $division)
    {
        if (! $request->user()->can('view', $division)) {
            return response()->json(['error' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $divisionTeams = [];
        if ($request->has('startDate') && $request->has('endDate')) {
            $validator = Validator::make($request->all(), [
                'startDate' => 'required|date_format:Y-m-d',
                'endDate' => 'required|date_format:Y-m-d',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
        }

        $divisionTeams = $this->service->getDivisionLeagueStandingsTeamsScores($division, $request->all());

        return response()->json([
            'data' => $divisionTeams,
        ]);
    }

    public function infoFaCup(Division $division)
    {
        $this->authorize('view', $division);
        $this->authorize('allowFaCup', $division);

        $events = EventsEnum::toArray();
        $columns = $this->service->leagueStandingColumnHideShow($division);

        JavaScript::put([
            'columns' => $columns,
            'events' => $events,
        ]);

        $allRounds = config('fa-cup.rounds');

        $playedRounds = $this->fixtureService->playedRoundsList($division);

        $currentRound = $this->fixtureService->getCurrentFaCupRound($division);

        return view('manager.divisions.info.fa_cup', compact('division', 'playedRounds', 'allRounds', 'currentRound'));
    }

    public function infoFaCupFilter(Request $request, Division $division)
    {
        $this->authorize('allowFaCup', $division);
        $divisionTeams = $this->service->getDivisionFaCupTeamsScores($division, $request->all());

        //If fixture is not played in selected round then it will show - in datatable
        if ($request->has('played') && $request->get('played') === 'no') {
            $data = [];
            foreach ($divisionTeams as $team) {
                $data[] = collect($team)->transform(function ($item, $key) {
                    return '-';
                });
            }
            $divisionTeams = $data;
        }

        return response()->json([
            'data' => $divisionTeams,
        ]);
    }

    public function infoHeadToHead(Division $division)
    {
        $this->authorize('allowHeadToHeadChairmanOrManager', $division);

        $teamCount = $this->service->adjustSize($division->divisionTeamsCurrentSeason()->approve()->count());
        $gameweeks = $this->gameWeekService->getGameWeekUsingSize($teamCount, $division);

        $activeWeekId = 0;

        if ($gameweeks) {
            $activeWeek = $gameweeks->first(function ($value, $key) {
                return $value->start->lte(now()) && $value->end->gte(now());
            });

            if (! $activeWeek) {
                $activeWeek = $gameweeks->first(function ($value, $key) {
                    return $value->start->gte(now());
                });
            }

            $activeWeekId = $activeWeek ? $activeWeek->id : 0;
        }

        return view('manager.divisions.info.head_to_head', compact('division', 'gameweeks', 'activeWeekId'));
    }

    public function infoHeadToHeadFilter(Request $request, Division $division)
    {
        $this->authorize('allowHeadToHeadChairmanOrManager', $division);
        
        if ($request->has('filter') && $request->get('filter') === 'matches') {
            $gameweek = GameWeek::find($request->get('id'));

            $divisionTeams = $this->headToHeadFixtureService->getDivisionHeadToHeadTeamsScoresFromGameWeek($division, $gameweek);
        } else {
            $divisionTeams = $this->headToHeadFixtureService->getDivisionHeadToHeadTeamsScores($division);
        }

        return response()->json([
            'data' => $divisionTeams,
        ]);
    }

    public function teamApprovals(\Illuminate\Http\Request $request, Division $division)
    {
        if ($request->user()->can('ownLeagues', $division)) {
            $team_approvals = $this->service->teamApprovals($division);

            return view('manager.divisions.approvals', compact('team_approvals', 'division'));
        } else {
            return redirect(route('manage.division.index'));
        }
    }

    public function approvalMsg(Team $team, Division $division)
    {
        return view('manager.divisions.approve_msg', compact('division'));
    }

    public function selectJoin()
    {
        return view('manager.divisions.select_join_league');
    }

    public function joinNewSocialLeague(Request $request)
    {
        return view('manager.divisions.join_new_social_league', [
            'divisions'=>$this->service->getSocialLeagues(),
        ]);
    }

    public function changePackage(Division $division)
    {
        $this->service->updateIsViewedPackageSelection($division);
        $seasonAvailablePackages = Season::find(Season::getLatestSeason())->available_packages;
        $packages = Package::where('private_league', YesNoEnum::YES)->whereIn('id', $seasonAvailablePackages)->get();
        $checkNewUserteam = $this->service->checkNewUserteam($division->chairman_id) && $this->service->checkNewUserteamPrevious($division->chairman_id);
        $divisionUid = Division::where('uuid', $division->uuid)->count();

        return view('manager.divisions.package_change', compact('division', 'packages', 'seasonAvailablePackages', 'checkNewUserteam', 'divisionUid'));
    }

    public function packageDescription(Division $division, Package $package)
    {
        $sealedBidDeadLinesEnum = SealedBidDeadLinesEnum::toSelectArray();
        $seasonAvailablePackages = Season::find(Season::getLatestSeason())->available_packages;
        $packages = Package::where('private_league', YesNoEnum::YES)->whereIn('id', $seasonAvailablePackages)->get();

        return view('manager.divisions.package.details', compact('package', 'sealedBidDeadLinesEnum', 'packages'));
    }

    public function updatePackage(Request $request, Division $division)
    {
        $dbPackageId = $division->package_id;

        $division = $this->service->updatePackage($division, $request->all(), $dbPackageId);

        if ($request['package_id'] != $dbPackageId) {
            $division = Division::find($division->id);
            $this->service->updateFreePlaceTeam($division);
        }

        if ($division) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();

            return redirect()->back();
        }
        if ($division->package->prize_packs) {
            return redirect(route('manage.division.prizepack.selection', ['division' => $division]));
        }

        return redirect(route('manage.division.info', ['division' => $division]));
    }

    public function prizePackSelection(Division $division)
    {
        $packagePrizePacks = $division->package->prize_packs;
        $prizePacks = PrizePack::whereIn('id', $packagePrizePacks)->orderBy('id', 'desc')->get();
        $defaultPackagePrizePack = $division->package->default_prize_pack;

        return view('manager.divisions.prize_pack_selection', compact('division', 'prizePacks', 'defaultPackagePrizePack'));
    }

    public function prizepackDescription(Division $division, PrizePack $prizePack)
    {
        return view('manager.divisions.prizepack.details', compact('prizePack'));
    }

    public function updatePrizePack(Request $request, Division $division)
    {
        if (auth()->user()->can('packageDisabled', $division)) {

            return abort(401);
        }
        
        $division = $this->service->updatePrizePack($division, $request->all());
        if ($division) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();

            return redirect()->back();
        }

        return redirect(route('manage.division.info', ['division' => $division]));
    }

    public function hallOfFame(Division $division)
    {
        $pastWinnerHistoryService = app(PastWinnerHistoryService::class);
        $histories = $pastWinnerHistoryService->getHallOfFame($division);
        // $histories = $division->histories->sortByDesc('season.start_at');

        return view('manager.divisions.info.hall_of_fame', compact('division', 'histories'));
    }

    public function joinAlreadySocialLeague(Request $request)
    {
        return view('manager.divisions.join_already_social_league', [
            'divisions'=>$this->service->getSocialLeagues(),
        ]);
    }
}
