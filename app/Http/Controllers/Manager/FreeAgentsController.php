<?php

namespace App\Http\Controllers\Manager;

use JavaScript;
use App\Enums\EventsEnum;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Services\ClubService;
use App\Services\FreeAgentService;
use App\Services\DivisionService;
use App\Http\Controllers\Controller;
use App\DataTables\FreeAgentsListDataTable;

class FreeAgentsController extends Controller
{
    const CLUB_PREMIER = 1;
    /**
     * @var FreeAgentService
     */
    protected $FreeAgentService;

    /**
     * @var clubService
     */
    protected $clubService;

    /**
     * @var DivisionService
     */
    protected $divisionService;

    /**
     * @var FreeAgentService
     */
    protected $freeAgentService;

    /**
     * FreeAgentsController constructor.
     *
     * @param PlayerService $playerService
     * @param ClubService $clubService
     */
    public function __construct(FreeAgentService $freeAgentService, ClubService $clubService, DivisionService $divisionService)
    {
        $this->clubService = $clubService;
        $this->divisionService = $divisionService;
        $this->freeAgentService = $freeAgentService;
    }

    /**
     * Fetch the list of free agent players of division.
     *
     * @param Division $division
     * @return \Illuminate\Http\Response
     */
    public function freeAgents(Division $division, Request $request)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        $this->authorize('isChairmanOrManager', [$division, $team]);

        $positions = ($division->playerPositionEnum())::toSelectArray();
        $clubs = $this->clubService->getClubs(['is_premier' => self::CLUB_PREMIER]);
        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $columns = $this->divisionService->leagueStandingColumnHideShow($division);
        $events = EventsEnum::toArray();

        JavaScript::put([
            'mergeDefenders' => $mergeDefenders,
            'defensiveMidfields' => $defensiveMidfields,
            'columns' => $columns,
            'events' => $events,
        ]);

        return view('manager.divisions.transfers.free_agents', compact('division', 'positions', 'clubs'));
    }

    /**
     * Fetch the list of free agent players of division.
     *
     * @param Division $division
     * @return \Illuminate\Http\Response
     */
    public function getFreeAgents(Division $division, FreeAgentsListDataTable $dataTable, Request $request)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        $this->authorize('isChairmanOrManager', [$division, $team]);

        return $dataTable->ajax();
    }

    public function getfreeAgentsPdf(Division $division, Request $request)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        $this->authorize('isChairmanOrManager', [$division, $team]);

        return $this->freeAgentService->getAllFreeAgents($division, $request->all(), 'pdf');
    }

    public function getfreeAgentsExcel(Division $division, Request $request)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        $this->authorize('isChairmanOrManager', [$division, $team]);

        return $this->freeAgentService->getAllFreeAgents($division, $request->all(), 'excel');
    }
}
