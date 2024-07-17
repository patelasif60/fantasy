<?php

namespace App\Http\Controllers\Manager;

use App\Enums\YesNoEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Fixture;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JavaScript;

class SwapController extends Controller
{
    /**
     * @var transferService
     */
    protected $transferService;

    public function __construct(TransferService $TransferService)
    {
        $this->transferService = $TransferService;
    }

    public function swap(Division $division)
    {
        if (config('fantasy.swap_feature_live') != 'true') {
            return abort(403);
        }
        $players = $this->transferService->getDivisionPlayers($division);
        $divisionTeams = $division->divisionTeams()->approve()->get();

        if ($division->getOptionValue('allow_weekend_changes') == YesNoEnum::YES) {
            $allowWeekendSwap = false;
        } else {
            $allowWeekendSwap = Fixture::checkFixtureForSwap();
        }

        JavaScript::put([
            'division' => $division,
            'chkFixture' => $allowWeekendSwap,
        ]);

        return view('manager.divisions.transfers.swap', compact('division', 'players', 'divisionTeams'));
    }

    public function getTeamPlayers(Division $division, Request $request)
    {
        return $this->transferService->getTeamPlayers($division, $request->teamId);
    }

    public function store(Division $division, Request $request)
    {
        $data = $request->all();

        $possible = $this->transferService->checkTransferPossible($data);

        if ($possible['status']) {
            $transfer = $this->transferService->swapPlayersContract($division, $data);

            if ($transfer) {
                return response()->json(['status'=> 'success', 'message'=> trans('messages.swap.saved.success')], Response::HTTP_OK);
            }

            return response()->json(['status'=> 'error', 'message'=> trans('messages.swap.saved.error')], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['status'=> 'error', 'message'=> $possible['message']], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
