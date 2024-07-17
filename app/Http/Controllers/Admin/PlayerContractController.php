<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PlayerContractDataTable;
use App\Enums\PlayerContractPositionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Player\Contract\StoreRequest;
use App\Http\Requests\Player\Contract\UpdateRequest;
use App\Models\Player;
use App\Models\PlayerContract;
use App\Services\ClubService;
use App\Services\PlayerContractService;
use Illuminate\Http\Response;

class PlayerContractController extends Controller
{
    /**
     * @var PlayerContractService
     */
    protected $service;

    /**
     * @var ClubService
     */
    protected $clubservice;

    /**
     * PlayerContractController constructor.
     *
     * @param PlayerContractService $service
     */
    public function __construct(PlayerContractService $service, ClubService $clubservice)
    {
        $this->service = $service;
        $this->clubservice = $clubservice;
    }

    /**
     * Fetch the players contract data for datatable.
     *
     * @param PlayerContractDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(PlayerContractDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Player $player)
    {
        $clubs = $this->clubservice->getPremierClubs();
        $positions = PlayerContractPositionEnum::getValues();

        return view('admin.players.contract.create', ['clubs' => $clubs, 'positions'=>$positions, 'player'=>$player]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContractStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store($player_id, StoreRequest $request)
    {
        $data = $request->all();
        $data['start_date'] = carbon_set_db_date($data['start_date']);
        if (! empty($data['end_date'])) {
            $data['end_date'] = carbon_create_from_date($data['end_date']);
        } else {
            $data['end_date'] = null;
        }
        $contract = $this->service->create($data + compact('player_id'));
        $status_code = Response::HTTP_OK;

        if ($contract) {
            $message = trans('messages.data.saved.success');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('player.validation.ct_date_overlap');
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player, PlayerContract $contract)
    {
        $clubs = $this->clubservice->getPremierClubs();
        $positions = PlayerContractPositionEnum::getValues();

        return view('admin.players.contract.edit', compact('contract', 'positions', 'clubs', 'player'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Player $player, PlayerContract $contract)
    {
        $data = $request->all();
        $data['start_date'] = carbon_set_db_date($data['start_date']);

        if (! empty($data['end_date'])) {
            $data['end_date'] = carbon_create_from_date($data['end_date']);
        } else {
            $data['end_date'] = null;
        }
        $contract = $this->service->update(
            $contract,
            $data
        );

        $status_code = Response::HTTP_OK;
        if ($contract) {
            $message = trans('messages.data.saved.success');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('messages.data.saved.error');
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    public function destroy(PlayerContract $contract)
    {
        if ($contract->delete()) {
            flash('Player Contract deleted successfully')->success();
        } else {
            flash('Player Contract could not be deleted. Please try again.')->error();
        }

        return redirect()->route('admin.players.edit', ['player'=>$contract->player_id]);
    }
}
