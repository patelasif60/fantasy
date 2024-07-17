<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Team;
use App\Services\TeamLineupService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TeamLineupController extends Controller
{
    /**
     * @var TeamLineup
     */
    protected $teamLineupService;

    /**
     * TeamLineupController constructor.
     *
     * @param TeamLineupService $service
     */
    public function __construct(TeamLineupService $teamLineupService)
    {
        $this->TeamLineupService = $teamLineupService;
    }

    public function getPlayerStats(Team $team)
    {
        $division = $team->teamDivision->first();

        $data = $this->TeamLineupService->getPlayerStats($division, $team);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function getPlayersForfixture(Request $request)
    {
        $data = $request->all();
        $data['fixture_date'] = $data['date'];
        $nextFixtureFlag = $this->TeamLineupService->checkTeamNextFixtureUpdatedData($data);
        $playersForFixture = $this->TeamLineupService->getPlayersForFixture($data['team_id'], $data['date']);

        return response()->json([
            'data' => $playersForFixture,
            'nextFixtureFlag' => $nextFixtureFlag,
        ]);
    }

    public function checkSuperSubData(Team $team)
    {
        $result = $this->TeamLineupService->checkSuperSubData($team);

        return response()->json([
            'data' => $result,
        ]);
    }

    public function checkTeamNextFixtureUpdatedData(Request $request)
    {
        $result = $this->TeamLineupService->checkTeamNextFixtureUpdatedData($request->all());

        return response()->json([
            'data' => $result,
        ]);
    }

    public function saveSuperSubData(Request $request)
    {
        $data = $request->all();

        $result = $this->TeamLineupService->saveSuperSubData($data);

        return response()->json([
            'data' => $result,
        ]);
    }

    public function deleteSuperSubData(Request $request)
    {
        $data = $request->all();

        $result = $this->TeamLineupService->deleteSuperSubData($data);

        return response()->json([
            'data' => $result,
        ]);
    }

    public function getTeamSuperSubFixtures(Request $request)
    {
        $data = $request->all();

        $result = $this->TeamLineupService->getTeamSuperSubFixtures($data);

        return response()->json([
            'data' => $result,
        ]);
    }

    public function sendConfirmationEmails(Division $division, Team $team)
    {
        $data = $this->TeamLineupService->sendConfirmationEmails($team);

        if(isset($data['status']) && $data['status'] == 'success') {

            return response()->json(['status' => $data['status'], 'message' => $data['message']], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => isset($data['message']) ? $data['message'] : ''], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function deleteAllSuperSubData(Division $division, Request $request)
    {
        $data = $request->all();

        $result = $this->TeamLineupService->deleteAllSuperSubData($data);

        return response()->json($result);
    }
}
