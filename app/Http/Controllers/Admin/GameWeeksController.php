<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\GameWeeksDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameWeek\StoreRequest;
use App\Http\Requests\GameWeek\UpdateRequest;
use App\Models\EuropeanPhase;
use App\Models\GameWeek;
use App\Models\LeaguePhase;
use App\Models\ProcupPhase;
use App\Models\Season;
use App\Services\DivisionService;
use App\Services\EuropeanPhaseService;
use App\Services\GameWeekService;
use App\Services\LeaguePhaseService;
use App\Services\ProcupPhaseService;

class GameWeeksController extends Controller
{
    /**
     * @var EuropeanPhaseService
     */
    protected $europeanPhaseService;

    /**
     * @var DivisionService
     */
    protected $divisionService;

    /**
     * @var ProcupPhaseService
     */
    protected $procupPhaseService;

    /**
     * @var LeaguePhaseService
     */
    protected $leaguePhaseService;

    /**
     * @var GameWeekService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param GameWeekService $service
     * @param DivisionService $divisionService
     * @param LeaguePhaseService $leaguePhaseService
     * @param ProcupPhaseService $procupPhaseService
     * @param EuropeanPhaseService $europeanPhaseService
     */
    public function __construct(GameWeekService $service, DivisionService $divisionService, LeaguePhaseService $leaguePhaseService, ProcupPhaseService $procupPhaseService, EuropeanPhaseService $europeanPhaseService)
    {
        $this->service = $service;
        $this->divisionService = $divisionService;
        $this->leaguePhaseService = $leaguePhaseService;
        $this->procupPhaseService = $procupPhaseService;
        $this->europeanPhaseService = $europeanPhaseService;
    }

    /**
     * Fetch the game week data for datatable.
     *
     * @param SeasonsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(GameWeeksDataTable $dataTable, Season $season)
    {
        return $dataTable->with('season', $season)->ajax();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Season $season)
    {
        $data = $request->all();
        $data['start'] = carbon_set_db_date($data['start']);
        $data['end'] = carbon_set_db_date($data['end']);

        $gameweek = $this->service->create($season, $data);

        if ($gameweek) {
            if ($request->get('champions_league')) {
                $this->europeanPhaseService->createChampionsLeaguePhase($gameweek, $request->get('champions_league'));
            }

            if ($request->get('europa_league')) {
                $this->europeanPhaseService->createEuropaLeaguePhase($gameweek, $request->get('europa_league'));
            }

            foreach (GameWeek::$leagueSeriesNumberOfTeams as $leagueSeries) {
                if (isset($request->get('league_series')[$leagueSeries]) && $request->get('league_series')[$leagueSeries]) {
                    $this->leaguePhaseService->create($gameweek, $leagueSeries, $request->get('league_series')[$leagueSeries]);
                }
            }

            foreach (GameWeek::$proCupNumberOfTeams as $proLeague) {
                if (isset($request->get('procup')[$proLeague]) && $request->get('procup')[$proLeague]) {
                    $this->procupPhaseService->create($gameweek, $proLeague, $request->get('procup')[$proLeague]);
                }
            }

            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.seasons.edit', ['season' => $season]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  GameWeek $gameweek
     * @return \Illuminate\Http\Response
     */
    public function edit(GameWeek $gameweek)
    {
        $phaseLeagueSeries = GameWeek::getLeagueSeries();
        $phaseProCup = GameWeek::getPhasesProCup();

        $leaguesCount = $this->divisionService->getPreviousSeasonDivisonCount();
        $phaseEuropaLeague = GameWeek::getPhasesEuropaLeague($leaguesCount);
        $phaseChampionsLeague = GameWeek::getPhasesChampionsLeague($leaguesCount);

        $leaguePhases = [];
        foreach ($gameweek->leaguePhases as $value) {
            $leaguePhases[$value->size] = ['name' => $value->name, 'id' => $value->id];
        }

        $proCupPhases = [];
        foreach ($gameweek->proCupPhases as $value) {
            $proCupPhases[$value->size] = ['name' => $value->name, 'id' => $value->id];
        }

        return view('admin.seasons.game_week.edit', compact('gameweek', 'phaseLeagueSeries', 'phaseProCup', 'phaseChampionsLeague', 'phaseEuropaLeague', 'leaguePhases', 'proCupPhases'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Gameweek $Gameweek
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, GameWeek $gameweek)
    {
        $data = $request->all();
        $data['start'] = carbon_set_db_date($data['start']);
        $data['end'] = carbon_set_db_date($data['end']);

        $gameweek = $this->service->update($gameweek, $data);
        if ($gameweek) {
            if (! $request->get('champions_league_id') && $request->get('champions_league')) {
                $this->europeanPhaseService->createChampionsLeaguePhase($gameweek, $request->get('champions_league'));
            } else {
                $europeanCompetitions = EuropeanPhase::find($request->get('champions_league_id'));
                if ($europeanCompetitions) {
                    if ($request->get('champions_league')) {
                        $this->europeanPhaseService->update($europeanCompetitions, $request->get('champions_league'));
                    } else {
                        //Temporary comment by asif
                        //$europeanCompetitions->delete();
                    }
                }
            }

            if (! $request->get('europa_league_id') && $request->get('europa_league')) {
                $this->europeanPhaseService->createEuropaLeaguePhase($gameweek, $request->get('europa_league'));
            } else {
                $europeanCompetitions = EuropeanPhase::find($request->get('europa_league_id'));
                if ($europeanCompetitions) {
                    if ($request->get('europa_league')) {
                        $this->europeanPhaseService->update($europeanCompetitions, $request->get('europa_league'));
                    } else {
                        //Temporary comment by asif
                        //$europeanCompetitions->delete();
                    }
                }
            }

            foreach (GameWeek::$leagueSeriesNumberOfTeams as $leagueSeries) {
                if (! isset($request->get('league_series_id')[$leagueSeries]) && $request->get('league_series')[$leagueSeries]) {
                    $this->leaguePhaseService->create($gameweek, $leagueSeries, $request->get('league_series')[$leagueSeries]);
                } else {
                    $leagueSeriesHeadToHead = LeaguePhase::find($request->get('league_series_id')[$leagueSeries]);
                    if ($leagueSeriesHeadToHead) {
                        if ($request->get('league_series')[$leagueSeries]) {
                            $this->leaguePhaseService->update($leagueSeriesHeadToHead, $request->get('league_series')[$leagueSeries]);
                        } else {
                            $leagueSeriesHeadToHead->delete();
                        }
                    }
                }
            }

            foreach (GameWeek::$proCupNumberOfTeams as $proLeague) {
                if (! isset($request->get('procup_id')[$proLeague]) && $request->get('procup')[$proLeague]) {
                    $this->procupPhaseService->create($gameweek, $proLeague, $request->get('procup')[$proLeague]);
                } else {
                    $proCup = ProcupPhase::find($request->get('procup_id')[$proLeague]);
                    if ($proCup) {
                        if ($request->get('procup')[$proLeague]) {
                            $this->procupPhaseService->update($proCup, $request->get('procup')[$proLeague]);
                        } else {
                            $proCup->delete();
                        }
                    }
                }
            }

            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('admin.seasons.edit', ['season' => $gameweek->season]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  GameWeek $gameweek
     * @return \Illuminate\Http\Response
     */
    public function destroy(GameWeek $gameweek)
    {
        $season = $gameweek->season;

        if ($gameweek->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.seasons.edit', ['season' => $season]);
    }
}
