<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TransfersDataTable;
use App\Enums\TransferErrorEnum;
use App\Enums\TransferTypeEnum;
use App\Http\Requests\Transfer\StoreRequest;
use App\Http\Requests\Transfer\UpdateRequest;
use App\Models\Transfer;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class TransfersController extends Controller
{
    /**
     * @var TransferService
     */
    protected $TransferService;

    /**
     * TransfersController constructor.
     *
     * @param TransferService $service
     */
    public function __construct(TransferService $service)
    {
        $this->service = $service;
    }

    /**
     * Fetch the transfer data for datatable.
     *
     * @param TransfersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(TransfersDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($team)
    {
        $transferType = TransferTypeEnum::toSelectArray();

        return view('admin.teams.transfer.create', compact('playersIn', 'playersOut', 'transferType', 'team'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $data['transfer_date'] = carbon_set_db_date_time($data['transfer_date']);
        $status = true;

        /*
         * If player out not selected
         * check team has size to insert new player in
        */
        if (Arr::has($data, 'player_out') && is_null($data['player_out'])) {
            $status = $this->service->checkTransferPossible($data);
        }

        $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;

        if ($status === true) {
            /**
             * Yes is transfer possible.
             */
            $transfer = $this->service->create($data);

            if ($transfer) {
                $status_code = Response::HTTP_OK;
                $message = trans('messages.data.saved.success');
            } else {
                $message = trans('messages.data.saved.error');
            }
        } else {
            /*
             * If transfer is not possible
             * following errors
            */

            if ($status == TransferErrorEnum::TEAM_FULL) {
                $message = trans('transfer.validation.squad_size_max');
            }
            if ($status == TransferErrorEnum::TEAM_LINEUP_FULL) {
                $message = trans('transfer.validation.lineup_size_max');
            }
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param transfer $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        $transferType = TransferTypeEnum::toSelectArray();

        return view('admin.teams.transfer.edit', compact('playersIn', 'playersOut', 'transfer', 'players', 'transferType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param transfer $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Transfer $transfer)
    {
        $transfer = $this->service->update($transfer, $request->all());

        $status_code = Response::HTTP_OK;
        if ($transfer) {
            $message = trans('messages.data.saved.success');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('messages.data.saved.error');
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    public function destroy(Transfer $transfer)
    {
        if ($transfer->delete()) {
            flash('Transfer deleted successfully')->success();
        } else {
            flash('Transfer could not be deleted. Please try again.')->error();
        }

        return redirect()->route('admin.teams.index');
    }

    /**
     * Fetch the transfer data for export.
     *
     * @param UsersDataTable $dataTable
     */
    public function export(TransfersDataTable $dataTable)
    {
        return $dataTable->csv();
    }

    public function getTransferPlayers(Request $request, $team)
    {
        $playersIn = $this->service->getPlayersIn($team, $request->all());
        $playersOut = $this->service->getPlayersOut($team);

        if ($playersOut) {
            $status_code = Response::HTTP_OK;
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json(['playersIn' => $playersIn, 'playersOut' => $playersOut], Response::HTTP_OK);
    }
}
