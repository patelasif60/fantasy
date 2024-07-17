<?php

namespace App\Http\Controllers\Manager;

use JavaScript;
use App\Models\CustomCup;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Services\TeamService;
use App\Services\GameWeekService;
use App\Services\CustomCupService;
use App\Http\Requests\Manager\CustomCup\StoreRequest;
use App\Http\Requests\Manager\CustomCup\UpdateRequest;

class CustomCupsController extends Controller
{
    /**
     * @var TeamService
     */
    protected $teamService;

    /**
     * @var GameWeekService
     */
    protected $gameWeekService;

    /**
     * @var CustomCupService
     */
    protected $service;

    /**
     * CustomCupsController constructor.
     */
    public function __construct(CustomCupService $service, TeamService $teamService, GameWeekService $gameWeekService)
    {
        $this->service = $service;
        $this->teamService = $teamService;
        $this->gameWeekService = $gameWeekService;
    }

    public function index(Request $request, Division $division)
    {
        $this->authorize('allowCustomCupChairman', $division);

        $division->load('customCup');

        $customCups = $division->customCup->sortByDesc('id');

        return view('manager.divisions.custom_cups.index', compact('division', 'customCups'));
    }

    public function create(Division $division)
    {
        $this->authorize('allowCustomCupChairman', $division);

        $teams = $this->teamService->getTeamForCustomCup($division);
        $gameweeks = $this->gameWeekService->getGameWeeksValidCups();
        $cancelUrl = route('manage.division.custom.cups.index', ['division' => $division]);

        return view('manager.divisions.custom_cups.create', compact('division', 'teams', 'gameweeks', 'cancelUrl'));
    }

    public function store(Division $division, StoreRequest $request)
    {
        $this->authorize('allowCustomCupChairman', $division);

        $customCup = $this->service->create($division, $request->all());

        if ($customCup) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('manage.division.custom.cups.index', ['division' => $division]);
    }

    public function round(Division $division, Request $request)
    {
        $this->authorize('allowCustomCupChairman', $division);

        $selectedRounds = [];
        if ($request->has('rounds') && $request->get('rounds') > 0) {
            if ($request->has('cup') && $request->get('cup') > 0) {
                $customCup = CustomCup::with('rounds', 'rounds.gameWeeks')->find($request->get('cup'));
                foreach ($customCup->rounds as $round) {
                    $selectedRounds[$round->round] = [];
                    foreach ($round->gameweeks as $gameweek) {
                        $selectedRounds[$round->round][$gameweek->gameweek_id] = true;
                    }
                }
            }

            $gameweeks = $this->gameWeekService->getGameWeeksValidCups();
            $rounds = $request->get('rounds');

            return view('manager.divisions.custom_cups.round', compact('gameweeks', 'rounds', 'selectedRounds'));
        }
    }

    public function edit(Division $division, CustomCup $customCup)
    {
        $this->authorize('update', $customCup);

        $teams = $this->teamService->getTeamForCustomCup($division);
        $gameweeks = $this->gameWeekService->getGameWeeksValidCups();
        $cancelUrl = route('manage.division.custom.cups.index', ['division' => $division]);
        $customCup = $customCup->load('teams');
        $selectedTeams = $customCup->teams->pluck('team_id')->toArray();
        $selectedTeamsBye = $customCup->teams->filter(function ($value, $key) {
            return $value->is_bye == true;
        })->pluck('team_id')->toArray();

        JavaScript::put([
            'selectedTeamsBye' => $selectedTeamsBye,
        ]);

        return view('manager.divisions.custom_cups.edit', compact('division', 'customCup', 'gameweeks', 'teams', 'cancelUrl', 'selectedTeams', 'selectedTeamsBye'));
    }

    public function update(Division $division, CustomCup $customCup, UpdateRequest $request)
    {
        $this->authorize('update', $customCup);

        $customCup = $this->service->update($division, $customCup, $request->all());

        if ($customCup) {
            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('manage.division.custom.cups.index', ['division' => $division]);
    }

    public function details(Division $division, CustomCup $customCup)
    {
        $this->authorize('detail', $customCup);

        $customCup->load('teams.team');

        $customCups = $division->customCup->sortByDesc('id');

        return view('manager.divisions.custom_cups.detail', compact('division', 'customCup', 'customCups'));
    }

    public function destroy(Division $division, CustomCup $customCup)
    {
        $this->authorize('delete', $customCup);

        if ($customCup->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('manage.division.custom.cups.index', ['division' => $division]);
    }
}
