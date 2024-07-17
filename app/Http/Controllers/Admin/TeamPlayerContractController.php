<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\Player\Contract\StoreRequest;
use App\Models\Player;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Services\TeamPlayerService;
use Illuminate\Http\Response;

class TeamPlayerContractController extends Controller
{
    /**
     * @var service
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param TeamPlayerService $service
     */
    public function __construct(TeamPlayerService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @param Team $team,Player $player
     * @return \Illuminate\Http\Response
     */
    public function data(Team $team, Player $player)
    {
        $contracts = $this->service->getContracts($team, $player);

        return view('admin.teams.players.contracts', compact('contracts', 'player', 'team'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request, Team $team, Player $player
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Team $team, Player $player)
    {
        $data = $request->all();
        if (isset($data['start_date_new'])) {
            $tmpArray = [];
            foreach ($data['start_date_new'] as $id => $value) {
                $tmpArray[$id] = ($data['start_date_new'][$id] ? carbon_set_db_date_time($data['start_date_new'][$id]) : null);
            }
            $data['start_date_new'] = $tmpArray;
        }

        if (isset($data['end_date_new'])) {
            $tmpArray = [];
            foreach ($data['end_date_new'] as $id => $value) {
                $tmpArray[$id] = ($data['end_date_new'][$id] ? carbon_set_db_date_time($data['end_date_new'][$id]) : null);
            }
            $data['end_date_new'] = $tmpArray;
        }

        if (isset($data['start_date'])) {
            $tmpArray = [];
            foreach ($data['start_date'] as $id => $value) {
                $tmpArray[$id] = ($data['start_date'][$id] ? carbon_set_db_date_time($data['start_date'][$id]) : null);
            }
            $data['start_date'] = $tmpArray;
        }

        if (isset($data['end_date'])) {
            $tmpArray = [];
            foreach ($data['end_date'] as $id => $value) {
                $tmpArray[$id] = ($data['end_date'][$id] ? carbon_set_db_date_time($data['end_date'][$id]) : null);
            }
            $data['end_date'] = $tmpArray;
        }

        $contract = $this->service->store($data, $team, $player);
        $status_code = Response::HTTP_OK;

        if ($contract) {
            $message = trans('messages.data.saved.success');
        } else {
            $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = trans('messages.data.saved.error');
        }

        return response()->json(['message'=>$message, 'errors'=>['message'=>[$message]]], $status_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamPlayerContract $contract)
    {
        if ($contract->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.teams.edit', ['team'=>$team]);
    }
}
