<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PlayerStatusDataTable;
use App\Enums\PlayerStatusEnum;
use App\Enums\PlayerStatusNoDateEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Player\Status\StoreRequest;
use App\Http\Requests\Player\Status\UpdateRequest;
use App\Models\Player;
use App\Models\PlayerStatus;
use App\Services\PlayerStatusService;
use Illuminate\Http\Response;

class PlayerStatusController extends Controller
{
    /**
     * @var PlayerStatusService
     */
    protected $service;

    /**
     * PlayerStatusController constructor.
     *
     * @param PlayerStatusService $service
     */
    public function __construct(PlayerStatusService $service)
    {
        $this->service = $service;
    }

    /**
     * Fetch the players data for datatable.
     *
     * @param PlayersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(PlayerStatusDataTable $dataTable, $player_id)
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
        $status_list = PlayerStatusEnum::toSelectArray();

        return view('admin.players.status.create', compact('player', 'status_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store($player_id, StoreRequest $request)
    {
        $data = $request->all();
        $data['start_date'] = carbon_set_db_date($data['start_date']);

        if (! empty($data['end_date'])) {
            $data['end_date'] = carbon_set_db_date($data['end_date']);
        } else {
            $data['end_date'] = null;
        }
        $status = $this->service->create($data + compact('player_id'));
        $status_code = Response::HTTP_OK;

        if ($status) {
            $message = trans('messages.data.saved.success');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('player.validation.st_date_overlap');
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player, PlayerStatus $status)
    {
        $disabled_end_date = false;
        $status_list = PlayerStatusEnum::toSelectArray();
        if (in_array($status->status, PlayerStatusNoDateEnum::getValues())) {
            $disabled_end_date = true;
        }

        return view('admin.players.status.edit', compact('player', 'status', 'disabled_end_date', 'status_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Player $player, PlayerStatus $status)
    {
        $data = $request->all();
        $data['start_date'] = carbon_set_db_date($data['start_date']);

        if (! empty($data['end_date'])) {
            $data['end_date'] = carbon_set_db_date($data['end_date']);
        } else {
            $data['end_date'] = null;
        }
        $status = $this->service->update(
            $status,
            $data
        );

        $status_code = Response::HTTP_OK;
        if ($status) {
            $message = trans('messages.data.saved.success');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('player.validation.st_date_overlap');
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlayerStatus $status)
    {
        if ($status->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.players.edit', ['player'=>$status->player_id]);
    }
}
