<?php

namespace App\Services;

use App\Enums\PlayerContractPositionEnum;
use App\Models\Team;
use App\Repositories\ClubRepository;
use App\Repositories\DivisionRepository;
use App\Repositories\HeadToHeadFixtureRepository;
use App\Repositories\LeagueReportRepository;
use App\Repositories\TeamLineupRepository;
use App\Repositories\TeamRepository;

class LeagueReportService
{
    /** @var DivisionRepository
     */
    protected $divisionService;

    /**
     * The Division repository instance.
     *
     * @var DivisionRepository
     */
    protected $divisionRepository;

    /**
     * The club repository instance.
     *
     * @var ClubRepository
     */
    protected $clubRepository;
    /**
     * The team repository instance.
     *
     * @var TeamRepository
     */
    protected $teamRepository;

    /**
     * The HeadToHeadFixture repository instance.
     *
     * @var HeadToHeadFixtureRepository
     */
    protected $headToHeadFixtureRepository;

    /**
     * The TeamLineup repository instance.
     *
     * @var TeamLineupRepository
     */
    protected $teamLineupRepository;

    /**
     * The LeagueReport repository instance.
     *
     * @var LeagueReportRepository
     */
    protected $leagueReportRepository;

    /**
     * Create a new service instance.
     *
     * @param TeamRepository $repository
     * @param ClubRepository $clubRepository
     */
    public function __construct(DivisionRepository $divisionRepository, TeamRepository $teamRepository, ClubRepository $clubRepository, LeagueReportRepository $leagueReportRepository, HeadToHeadFixtureRepository $headToHeadFixtureRepository, TeamLineupRepository $teamLineupRepository, DivisionService $divisionService)
    {
        $this->teamRepository = $teamRepository;
        $this->clubRepository = $clubRepository;
        $this->divisionRepository = $divisionRepository;
        $this->teamLineupRepository = $teamLineupRepository;
        $this->leagueReportRepository = $leagueReportRepository;
        $this->headToHeadFixtureRepository = $headToHeadFixtureRepository;
        $this->divisionService = $divisionService;
    }

    public function getTeam($team)
    {
        return $this->teamRepository->getTeam($team);
    }

    public function getClubs($where = [])
    {
        return $this->clubRepository->getClubs($where);
    }

    public function getDivisionPlayers($division, $data = [])
    {
        return $this->divisionRepository->getDivisionPlayers($division, $data);
    }

    public function getDivisionTeamPlayers($division, $team)
    {
        return $this->divisionRepository->getDivisionTeamPlayers($division, $team);
    }

    public function getDivisionReportData($division)
    {
        return $this->divisionRepository->getDivisionReportData($division);
    }

    public function sendEmail($division, $user)
    {
        $reportFile = $this->buildLeagueReport($division, $user);

        return $this->leagueReportRepository->sendEmail($division, $user, $reportFile);
    }

    public function buildLeagueReport($division, $user)
    {

        //Get Start and End Dates for report
        $gameweek = $this->leagueReportRepository->getCurrentGameWeek();

        $reportDuration = [
            'startDate'=>$gameweek->season->start_at->toDateString(),
            'endDate'=>$gameweek->end->toDateString(),
        ];

        //Get Data for Report Tables
        $leagueTable = $this->divisionService->getDivisionLeagueStandingsTeamsScores($division, $reportDuration);

        $monthlyForm = $this->leagueReportRepository->getMonthlyFormData($division);

        $leagueSeries = $this->headToHeadFixtureRepository->getDivisionHeadToHeadTeamsScores($division);

        $teamPlayers = [];
        foreach ($division->divisionTeams as $team) {
            $teamPlayers[$team->id] = $this->teamLineupRepository->getLineupDataForReport($team, $division, $forPDF = true);
        }

        $formGuide = [];
        $positions = PlayerContractPositionEnum::toArray();
        foreach ($positions as $key => $position) {
            $formGuide[$key] = $this->divisionRepository->getDivisionPlayers($division->id, ['position'=>$position] + $reportDuration, true);
            $this->leagueReportRepository->attachPlayedMatchesToFormGuide($formGuide[$key]);
        }

        //Pass Report Data to generate PDF
        $reportFile = $this->leagueReportRepository->buildPDFReportFile(
            $division,
            $user,
            compact('gameweek', 'leagueTable', 'monthlyForm', 'leagueSeries', 'teamPlayers', 'formGuide')
        );

        return $reportFile;
    }
}
