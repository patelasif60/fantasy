<?php

namespace App\Http\Controllers\Api;

use App\DataTables\OwnedPlayersListDataTable;
use App\Enums\EventsEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Services\ClubService;
use App\Services\DivisionService;

class WhoOwnsWhoController extends Controller
{
    const CLUB_PREMIER = 1;
    /**
     * @var clubService
     */
    protected $clubService;

    /**
     * @var DivisionService
     */
    protected $divisionService;

    /**
     * WhoOwnsWhoController constructor.
     *
     * @param ClubService $clubService
     */
    public function __construct(ClubService $clubService, DivisionService $divisionService)
    {
        $this->clubService = $clubService;
        $this->divisionService = $divisionService;
    }

    /**
     * Fetch the list of owned players of division.
     *
     * @param Division $division
     * @return \Illuminate\Http\Response
     */
    public function whoOwnsWho(Division $division)
    {
        $positions = ($division->playerPositionEnum())::toSelectArray();
        $clubs = $this->clubService->getClubs(['is_premier' => self::CLUB_PREMIER]);
        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $columns = $this->divisionService->leagueStandingColumnHideShow($division);
        $events = EventsEnum::toArray();

        return response()->json([
            'positions' => $positions,
            'clubs' => $clubs,
            'mergeDefenders' => $mergeDefenders,
            'defensiveMidfields' => $defensiveMidfields,
            'columns' => $columns,
            'events' => $events,
        ]);
    }

    /**
     * Fetch the list of owned players of division.
     *
     * @param Division $division
     * @return \Illuminate\Http\Response
     */
    public function getOwnedPlayers(Division $division, OwnedPlayersListDataTable $dataTable)
    {
        $columns = $this->divisionService->leagueStandingColumnHideShow($division);

        //$data = json_decode(json_encode($dataTable->ajax()), true);

        return response()->json([
            'columns' => $columns,
            'data' => @$dataTable->ajax()->original,
        ]);
    }
}
