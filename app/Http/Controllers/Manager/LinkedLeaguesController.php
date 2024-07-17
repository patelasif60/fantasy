<?php

namespace App\Http\Controllers\Manager;

use App\Enums\EventsEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\ParentLinkedLeague;
use App\Models\Season;
use App\Services\DivisionService;
use App\Services\LinkedLeagueService;
use Illuminate\Http\Request;
use JavaScript;
use Session;

class LinkedLeaguesController extends Controller
{
    /**
     * @var service
     */
    protected $service;

    /**
     * @var divisionService
     */
    protected $divisionService;

    public function __construct(LinkedLeagueService $linkedLeagueService, DivisionService $divisionService)
    {
        $this->service = $linkedLeagueService;
        $this->divisionService = $divisionService;
    }

    public function index(Division $division)
    {
        $this->authorize('view', $division);

        if (Session::has('linkedLeague')) {
            Session::forget('linkedLeague');
        }
        $linkedLeagues = $this->service->getLinkedLeagues($division);

        return view('manager.divisions.linked_league.league_list', compact('division', 'linkedLeagues'));
    }

    public function searchLeague(Division $division)
    {
        $this->authorize('ownLeagues', $division);

        return view('manager.divisions.linked_league.search_league', compact('division'));
    }

    public function searchLeagueByValue(Division $division, Request $request)
    {
        $this->authorize('ownLeagues', $division);

        $allLeagues = $this->service->getSearchLeagueResults($division, $request->all());

        return view('manager.divisions.linked_league.search_league_results', compact('division', 'allLeagues'));
    }

    public function selectLeague(Division $division, $league)
    {
        $this->authorize('ownLeagues', $division);

        $allLeagues = $this->service->getLeagueData($division, [$league]);
        $selectLeague = $this->service->storeSelectedLeague($division, $league);

        return view('manager.divisions.linked_league.select_league', compact('division', 'allLeagues'));
    }

    public function getAllSelectedLeague(Division $division)
    {
        $this->authorize('ownLeagues', $division);

        $linkedLeague = Session::get('linkedLeague');
        $selectedLeagues = $linkedLeague[$division->id];
        $allLeagues = $this->service->getLeagueData($division, $selectedLeagues);

        return view('manager.divisions.linked_league.selected_league', compact('division', 'allLeagues'));
    }

    public function saveLinkedLeague(Division $division, Request $request)
    {
        $this->authorize('ownLeagues', $division);

        $this->service->saveSelectedLeague($division, $request->all());

        return view('manager.divisions.linked_league.save_linked_league', compact('division'));
    }

    public function store(Division $division, Request $request)
    {
        $this->authorize('ownLeagues', $division);

        if ($this->service->store($division, $request->all())) {

            flash(__('messages.data.saved.success'))->success();

            return redirect()->route('manage.division.info', ['division' => $division]);
        }

        flash(__('messages.data.saved.error'))->error();

        return redirect()->back();
    }

    public function leagueInfo(Request $request, Division $division, ParentLinkedLeague $parentLinkedLeague)
    {
        $this->authorize('view', $division);

        $season = Season::with('gameweeks')->find(Season::getLatestSeason());
        $gameweeks = $season->gameweeks;

        $activeWeekId = 0;
        if ($gameweeks) {
            $activeWeek = $gameweeks->where('start', '<=', now())->where('end', '>=', now());
            if ($activeWeek->count()) {
                $activeWeekId = $activeWeek->first()->id;
            } else {
                $activeWeek = $gameweeks->where('start', '<=', now())->last();
                $activeWeekId = $activeWeek ? $activeWeek->id : $gameweeks->last()->id;
            }
        }

        $events = EventsEnum::toArray();
        $columns = $this->divisionService->leagueStandingColumnHideShow($division);

        JavaScript::put([
            'columns' => $columns,
            'events' => $events,
            'linkedLeague' => $parentLinkedLeague->id,
        ]);

        $months = carbon_get_months_between_dates($season->start_at, $season->end_at);

        return view('manager.divisions.linked_league.link_league_info', compact('division', 'months', 'gameweeks', 'activeWeekId', 'parentLinkedLeague'));
    }
}
