<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\LeagueTitle;
use App\Services\SeasonService;
use App\Models\PastWinnerHistory;
use Illuminate\Http\JsonResponse;
use App\Services\PastWinnerHistoryService;
use App\Http\Requests\Api\History\StoreRequest;
use App\Http\Requests\Api\History\UpdateRequest;
use App\Http\Resources\Season as SeasonResource;
use App\Http\Controllers\Api\Controller as BaseController;
use App\Http\Resources\PastWinnerHistory as PastWinnerHistoryResource;

class PastWinnerHistoryController extends BaseController
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
        if (! $request->user()->can('view', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        // $division->load('histories.season');

        $histories = $this->service->getHallOfFame($division);

        // $histories = $division->histories->sortByDesc('season.start_at');

        return response()->json([
            'data' => PastWinnerHistoryResource::collection($histories),
        ]);
    }

    public function create(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $seasonIds = $division->histories()->pluck('season_id');
        $seasons = $this->seasonService->getSeasonsFromIds($seasonIds);
        $managers = $division->divisionTeams->load('consumer.user')->pluck('consumer');

        $managersName = $managers->map(function ($item) use($division) {
            return $item->user->first_name.' '.$item->user->last_name;
        });

        return response()->json([
            'seasons' => SeasonResource::collection($seasons),
            'managers' => $managersName,
        ]);
    }

    public function store(Division $division, StoreRequest $request)
    {
        if (! $request->user()->can('ownLeagues', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $history = $this->service->create($division, $request->all());
        $updateLeagueTitle = $this->updateLeagueTitle($history, $request->all(), 'add');

        if ($history) {
            return response()->json(['status' => 'success', 'message' => __('messages.data.saved.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.saved.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function edit(Request $request, Division $division, PastWinnerHistory $history)
    {
        if (! $request->user()->can('ownLeagues', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $division->load('divisionTeams','histories.season');

        $seasonIds = $division->histories()->pluck('season_id')->reject(function ($id) use ($history) {
            return $history->season_id === $id;
        });

        $seasons = $this->seasonService->getSeasonsFromIds($seasonIds);

        $managers = $division->divisionTeams->load('consumer.user')->pluck('consumer');

        $managersName = $managers->map(function ($item) use($division) {
            return $division->chairman_id == $item->id ? null : $item->user->first_name.' '.$item->user->last_name;
        })
        ->reject(function ($item) {
            return empty($item);
        });

        $customManager = PastWinnerHistory::where('division_id', $division->id)->pluck('name');
        $customMargeArrayManager = $managersName->merge(collect($customManager))->unique();

        return response()->json([
            'data' => new PastWinnerHistoryResource($history->load('season')),
            'seasons' => SeasonResource::collection($seasons),
            'managers' => $customMargeArrayManager,
        ]);

        return view('manager.divisions.history.edit', compact('division', 'history', 'seasons'));
    }

    public function update(Division $division, PastWinnerHistory $history, UpdateRequest $request)
    {
        if (! $request->user()->can('ownLeagues', $division)) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }
        $updateLeagueTitle = $this->updateLeagueTitle($history, $request->all(), 'update');
        $history = $this->service->update($history, $request->all());

        if ($history) {
            return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.updated.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function delete(Division $division, PastWinnerHistory $history)
    {
        $name = $history->name;
        $division_id = $history->division_id;
        $updateLeagueTitle = $this->updateLeagueTitle($division_id, $name, 'delete');
        $delete = PastWinnerHistory::find($history->id)->delete();
        if ($delete) {
            return response()->json(['status' => 'success', 'message' =>'Deleted Successfully!'], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' =>'Please Try Again Later'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function updateLeagueTitle($history, $request, $mod)
    {
        $ids = $history->division->getDivisionFromUuid();

        if ($mod == 'update') {
            $leagueTitles = LeagueTitle::whereIn('division_id', $ids)->where('name', $history->name)->get();
            $name = $request['name'];
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
