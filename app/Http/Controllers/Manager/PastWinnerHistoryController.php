<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests\Manager\History\StoreRequest;
use App\Http\Requests\Manager\History\UpdateRequest;
use App\Models\Division;
use App\Models\LeagueTitle;
use App\Models\PastWinnerHistory;
use App\Services\PastWinnerHistoryService;
use App\Services\SeasonService;
use Illuminate\Http\Request;

class PastWinnerHistoryController extends Controller
{
    /**
     * @var PastWinnerHistoryService
     */
    protected $service;

    /**
     * @var SeasonService
     */
    protected $seasonService;

    /**
     * PastWinnerHistoryController constructor.
     */
    public function __construct(PastWinnerHistoryService $service, SeasonService $seasonService)
    {
        $this->service = $service;
        $this->seasonService = $seasonService;
    }

    public function index(Request $request, Division $division)
    {
        $this->authorize('ownLeagues', $division);

        $histories = $this->service->getHallOfFame($division);

        return view('manager.divisions.history.index', compact('division', 'histories'));
    }

    public function create(Division $division)
    {
        $this->authorize('ownLeagues', $division);

        $seasonIds = $division->histories()->pluck('season_id');
        $seasons = $this->seasonService->getSeasonsFromIds($seasonIds);
        $managers = $division->divisionTeams->load('consumer')->pluck('consumer');

        return view('manager.divisions.history.create', compact('division', 'seasons', 'managers'));
    }

    public function store(Division $division, StoreRequest $request)
    {
        $this->authorize('ownLeagues', $division);

        $history = $this->service->create($division, $request->all());
        $updateLeagueTitle = $this->updateLeagueTitle($history, $request->all(), 'add');

        if ($history) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('manage.division.history.index', ['division' => $division]);
    }

    public function edit(Division $division, PastWinnerHistory $selectedhistory)
    {
        $this->authorize('ownLeagues', $division);

        $division->load('divisionTeams','histories.season');

        $seasonIds = $division->histories()->pluck('season_id')->reject(function ($id) use ($selectedhistory) {
            return $selectedhistory->season_id === $id;
        });

        $seasons = $this->seasonService->getSeasonsFromIds($seasonIds);

        $histories = $division->histories->sortByDesc('season.start_at');

        $managers = $division->divisionTeams->load('consumer.user')->pluck('consumer');

        $managersName = $managers->map(function ($item) use($division) {
            return $division->chairman_id == $item->id ? null : $item->user->first_name.' '.$item->user->last_name;
        })
        ->reject(function ($item) {
            return empty($item);
        });
        
        $customManager = PastWinnerHistory::where('division_id', $division->id)->pluck('name');
        $customMargeArrayManager = $managersName->merge(collect($customManager))->unique();

        return view('manager.divisions.history.edit', compact('division', 'selectedhistory', 'seasons', 'histories', 'managers', 'customMargeArrayManager'));
    }

    public function update(Division $division, PastWinnerHistory $history, UpdateRequest $request)
    {
        $this->authorize('ownLeagues', $division);
        $updateLeagueTitle = $this->updateLeagueTitle($history, $request->all(), 'update');
        $history = $this->service->update($history, $request->all());

        if ($history) {
            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('manage.division.history.index', ['division' => $division]);
    }

    public function delete(Division $division, PastWinnerHistory $history)
    {
        $updateLeagueTitle = $this->updateLeagueTitle($history, [], 'delete');
        $delete = PastWinnerHistory::find($history->id)->delete();
        if ($delete) {
            flash('Team Deleted Successfully!')->success();
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            flash('Please Try Again Later!')->error();
        }

        return redirect()->route('manage.division.history.index', ['division' => $division]);
    }

    public function updateLeagueTitle($history, $request, $mod)
    {
        $ids = $history->division->getDivisionFromUuid();

        if ($mod == 'update') {

            $name = $request['name'];
            $leagueTitles = LeagueTitle::whereIn('division_id', $ids)->where('name', $history->name)->get();
            
            if ($name != $history->name) {
                if ($leagueTitles->count()) {
                    foreach ($leagueTitles as $leagueTitle) {
                        $titles = $leagueTitle->titles;
                        if($titles >= 1) {
                            $titles = $titles - 1;
                            $leagueTitle = $leagueTitle->fill([
                                'titles' => $titles <= 0 ? 0 : $titles,
                            ]);
                            $leagueTitle->save();
                            break;
                        }
                    }
                }
                $addleagueTitles = LeagueTitle::whereIn('division_id', $ids)->where('name', $name)->get();

                if ($addleagueTitles->count()) {
                    foreach ($addleagueTitles as $addleagueTitle) {
                        $titles = $addleagueTitle->titles;
                        if($titles >= 1) {
                            $titles = $titles + 1;
                            $addleagueTitle = $addleagueTitle->fill([
                                'titles' => $titles <= 0 ? 0 : $titles,
                            ]);
                            $addleagueTitle->save();
                            break;
                        }
                    }
                } else {
                    $create = LeagueTitle::create([
                        'division_id' => $history->division_id,
                        'titles' => 1,
                        'name'=> $name,
                    ]);
                }
            }
        } elseif ($mod == 'delete') {
            $leagueTitles = LeagueTitle::whereIn('division_id', $ids)->where('name', $history->name)->get();

            if ($leagueTitles->count()) {
                foreach ($leagueTitles as $leagueTitle) {
                    $titles = $leagueTitle->titles;
                    if($titles >= 1) {
                        $titles = $titles - 1;
                        $leagueTitle = $leagueTitle->fill([
                            'titles' => $titles <= 0 ? 0 : $titles,
                        ]);
                        $leagueTitle->save();
                        break;
                    }
                }
            }
        } else {
            $name = $request['name'];
            $addleagueTitles = LeagueTitle::whereIn('division_id', $ids)->where('name', $name)->get();
            if ($addleagueTitles->count()) {
                foreach ($addleagueTitles as $addleagueTitle) {
                    $titles = $addleagueTitle->titles;
                    if($titles >= 1) {
                        $titles = $titles + 1;
                        $addleagueTitle = $addleagueTitle->fill([
                            'titles' => $titles <= 0 ? 0 : $titles,
                        ]);
                        $addleagueTitle->save();
                        break;
                    }
                }
            } else {
                $create = LeagueTitle::create([
                    'division_id' => $history->division_id,
                    'titles' => 1,
                    'name'=> $request['name'],
                ]);
            }
        }
    }
}
