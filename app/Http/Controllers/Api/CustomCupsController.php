<?php

namespace App\Http\Controllers\Api;

use App\Models\CustomCup;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use App\Services\CustomCupService;
use App\Services\GameWeekService;
use App\Http\Resources\Team as TeamResource;
use App\Http\Requests\Api\CustomCup\StoreRequest;
use App\Http\Requests\Api\CustomCup\UpdateRequest;
use App\Http\Resources\GameWeek as GameWeekResource;
use App\Http\Resources\CustomCup as CustomCupResource;
use App\Http\Controllers\Api\Controller as BaseController;
use App\Http\Resources\CustomCupRound as CustomCupRoundResource;

class CustomCupsController extends BaseController
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
        if (! $request->user()->can('allowCustomCupChairman', $division)) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $division->load('customCup');

        $customCups = $division->customCup->sortByDesc('id');

        return response()->json([
            'data' => CustomCupResource::collection($customCups),
        ]);
    }

    public function create(Request $request, Division $division)
    {
        if (! $request->user()->can('allowCustomCupChairman', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $teams = $this->teamService->getTeamForCustomCup($division);
        $gameweeks = $this->gameWeekService->getGameWeeksValidCups();

        return response()->json([
            'teams' => TeamResource::collection($teams->load('consumer')),
            'gameweeks' => GameWeekResource::collection($gameweeks),
        ]);
    }

    public function store(Division $division, StoreRequest $request)
    {
        if (! $request->user()->can('allowCustomCupChairman', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $customCup = $this->service->create($division, $request->all());

        if ($customCup) {
            return response()->json(['status' => 'success', 'message' => __('messages.data.saved.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.saved.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function edit(Request $request, Division $division, CustomCup $customCup)
    {
        if (! $request->user()->can('update', $customCup)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $customCup->load('teams', 'rounds');

        $teams = $this->teamService->getTeamForCustomCup($division);
        $gameweeks = $this->gameWeekService->getGameWeeksValidCups();

        return response()->json([
            'data' => new CustomCupResource($customCup),
            'selectedTeams' => $customCup->teams,
            'selectedRounds' => CustomCupRoundResource::collection($customCup->rounds->load('gameWeeks.gameweek')),
            'teams' => TeamResource::collection($teams->load('consumer')),
            'gameweeks' => GameWeekResource::collection($gameweeks),
        ]);
    }

    public function update(Division $division, CustomCup $customCup, UpdateRequest $request)
    {
        if (! $request->user()->can('update', $customCup)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $customCup = $this->service->update($division, $customCup, $request->all());

        if ($customCup) {

            return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.updated.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function details(Request $request, Division $division, CustomCup $customCup)
    {
        if (! $request->user()->can('detail', $customCup)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $customCup->load('rounds.gameweeks.gameweek', 'teams.team');

        return response()->json([
            'data' => new CustomCupResource($customCup),
            'teams' => $customCup->teams,
            'rounds' => $customCup->rounds,
        ]);
    }

    public function destroy(Request $request, Division $division, CustomCup $customCup)
    {
        if (! $request->user()->can('delete', $customCup)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if ($customCup->delete()) {

            return response()->json(['status' => 'success', 'message' => __('messages.data.deleted.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.deleted.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
