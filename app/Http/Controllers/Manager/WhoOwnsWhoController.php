<?php

namespace App\Http\Controllers\Manager;

use App\DataTables\OwnedPlayersListDataTable;
use App\Enums\EventsEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Services\ClubService;
use App\Services\DivisionService;
use JavaScript;

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

        JavaScript::put([
            'mergeDefenders' => $mergeDefenders,
            'defensiveMidfields' => $defensiveMidfields,
            'columns' => $columns,
            'events' => $events,
        ]);

        return view('manager.divisions.transfers.who_owns_who', compact('division', 'positions', 'clubs'));
    }

    /**
     * Fetch the list of owned players of division.
     *
     * @param Division $division
     * @return \Illuminate\Http\Response
     */
    public function getOwnedPlayers(Division $division, OwnedPlayersListDataTable $dataTable)
    {
        return $dataTable->ajax();
    }
}
