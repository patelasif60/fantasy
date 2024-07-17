<?php

namespace App\Http\Controllers\Api;

use App\Enums\EventsEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\ParentLinkedLeague;
use App\Models\Season;
use App\Services\DivisionService;
use App\Services\LinkedLeagueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkedLeaguesController extends Controller
{
    /**
     * @var service
     */
    protected $service;

    /**
     * @var divisionService
     */
    protected $divisionService;

    const LEAGUE_ID = 'leagueId';
    const LEAGUE_NAME = 'leagueName';

    public function __construct(LinkedLeagueService $linkedLeagueService, DivisionService $divisionService)
    {
        $this->service = $linkedLeagueService;
        $this->divisionService = $divisionService;
    }

    public function index(Request $request, Division $division)
    {
        if (! $request->user()->can('view', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        return response()->json([
            'data' => $this->service->getLinkedLeagues($division),
        ]);
    }

    public function leagueInfo(Request $request, Division $division, ParentLinkedLeague $parentLinkedLeague)
    {
        if (! $request->user()->can('view', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $season = Season::with('gameweeks')->find(Season::getLatestSeason());
        $gameweeks = $season->gameweeks;

        $activeWeekId = 0;
        if ($gameweeks) {
            $activeWeek = $gameweeks->where('start', '<=', now())->where('end', '>=', now());
            if ($activeWeek->count()) {
                $activeWeekId = $activeWeek->first()->id;
            } else {
                $activeWeek = $gameweeks->where('start', '<=', now())->last();
                $activeWeekId = $activeWeek ? $activeWeek->id : $gameweeks->last()->id;
            }
        }

        $data['months'] = carbon_get_months_between_dates($season->start_at, $season->end_at);
        $data['gameweeks'] = $gameweeks;
        $data['activeWeekId'] = $activeWeekId;
        $data['parentLinkedLeague'] = $parentLinkedLeague->id;
        $data['events'] = EventsEnum::toArray();
        $data['columns'] = $this->divisionService->
                            leagueStandingColumnHideShow($division);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function searchLeagueByValue(Division $division, Request $request)
    {
        if (! $request->user()->can('ownLeagues', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if ($request->has('search_type') && $request->has('search_league') &&
                (($request->get('search_type') === self::LEAGUE_ID &&
                 is_numeric($request->get('search_league'))) ||
                $request->get('search_type') === self::LEAGUE_NAME)
            ) {
            $allLeagues = $this->service->getSearchLeagueResults($division, $request->all());

            return response()->json([
                'data' => $allLeagues,
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function save(Division $division, Request $request)
    {
        if (! $request->user()->can('ownLeagues', $division)) {
            
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if ($request->has('linkLeagueName') &&
                ($request->has('childLeagues') &&
                 count($request['childLeagues'])
                )
        ) {
            if ($this->service->save($division, $request->all())) {
                return response()->json(['status'=> 'success', 'message'=> trans('messages.data.saved.success')], JsonResponse::HTTP_OK);
            }

            return response()->json(['status'=> 'error', 'message'=> trans('messages.data.saved.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
