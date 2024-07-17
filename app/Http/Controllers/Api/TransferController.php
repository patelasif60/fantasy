<?php

namespace App\Http\Controllers\Api;

use App\DataTables\ChangeHistoryDataTable;
use App\Enums\HistoryPeriodEnum;
use App\Enums\HistoryTransferTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Services\TransferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    protected $service;

    /**
     * TransferController constructor.
     *
     * @param TransferService $service
     */
    public function __construct(TransferService $service)
    {
        $this->service = $service;
    }

    public function showTransfersMenu(Division $division, Request $request)
    {
        return response()->json([
            'transfer_button' => $request->user()->can('isTransferEnabled', $division),
            'swaps_button' => $request->user()->can('ownLeagues', $division) ? true : false,
            'enter_sealed_bid_button' => $request->user()->can('ownLeagues', $division) ? false : true,
        ]);
    }

    public function history(Division $division)
    {
        try {
            $data['transferTypes'] = HistoryTransferTypeEnum::toSelectArray();
            $data['periodEnum'] = HistoryPeriodEnum::toArray();

            return response()->json(['status' => 'success', 'data' => $data], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function divisionTransferHistory(Request $request, Division $division, ChangeHistoryDataTable $dataTable)
    {
        try {
            return response()->json(['status' => 'success', 'data' =>  @$dataTable->ajax()->original], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
