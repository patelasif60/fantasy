<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PackagesDataTable;
use App\Enums\AgentTransferAfterEnum;
use App\Enums\AuctionTypesEnum;
use App\Enums\BadgeColorEnum;
use App\Enums\DigitalPrizeTypeEnum;
use App\Enums\EventsEnum;
use App\Enums\FormationEnum;
use App\Enums\MoneyBackEnum;
use App\Enums\PositionsEnum;
use App\Enums\SealedBidDeadLinesEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\TransferAuthorityEnum;
use App\Enums\YesNoEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Package\StoreRequest;
use App\Http\Requests\Package\UpdateRequest;
use App\Models\Package;
use App\Services\PackageService;
use App\Services\PrizePackService;
use Illuminate\Support\Arr;

class PackagesController extends Controller
{
    /**
     * @var PackageService
     */
    protected $service;

    /**
     * @var prizePackService
     */
    protected $prizePackService;

    /**
     * Create a new controller instance.
     *
     * @param PackageService $service
     */
    public function __construct(PackageService $service, PrizePackService $prizePackService)
    {
        $this->service = $service;
        $this->prizePackService = $prizePackService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.packages.index');
    }

    /**
     * Fetch the packages data for datatable.
     *
     * @param PackagesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(PackagesDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $yesNo = YesNoEnum::toSelectArray();
        $auctionTypesEnum = AuctionTypesEnum::toSelectArray();
        $sealedBidDeadLinesEnum = SealedBidDeadLinesEnum::toSelectArray();
        $moneyBackEnum = MoneyBackEnum::toSelectArray();
        $tiePreferenceEnum = TiePreferenceEnum::toSelectArray();
        $formation = FormationEnum::toSelectArray();
        $transferAuthority = TransferAuthorityEnum::toSelectArray();
        $agentTransferAfterEnum = AgentTransferAfterEnum::toSelectArray();
        $digitalPrizeTypeEnum = DigitalPrizeTypeEnum::toSelectArray();
        $positionsEnum = PositionsEnum::toSelectArray();
        $eventsEnum = EventsEnum::toSelectArray();
        $allPrizePacks = $this->prizePackService->getAll();
        $badgeColors = BadgeColorEnum::toSelectArray();

        return view('admin.packages.create', compact('yesNo', 'auctionTypesEnum', 'sealedBidDeadLinesEnum', 'moneyBackEnum', 'tiePreferenceEnum', 'formation', 'transferAuthority', 'agentTransferAfterEnum', 'digitalPrizeTypeEnum', 'positionsEnum', 'eventsEnum', 'allPrizePacks', 'badgeColors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $data['first_seal_bid_deadline'] = (! is_null(Arr::get($data, 'first_seal_bid_deadline')) ? carbon_set_db_date_time($data['first_seal_bid_deadline']) : null);
        $package = $this->service->create($data);

        if ($package) {
            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.packages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $yesNo = YesNoEnum::toSelectArray();
        $auctionTypesEnum = AuctionTypesEnum::toSelectArray();
        $sealedBidDeadLinesEnum = SealedBidDeadLinesEnum::toSelectArray();
        $moneyBackEnum = MoneyBackEnum::toSelectArray();
        $tiePreferenceEnum = TiePreferenceEnum::toSelectArray();
        $formation = FormationEnum::toSelectArray();
        $transferAuthority = TransferAuthorityEnum::toSelectArray();
        $agentTransferAfterEnum = AgentTransferAfterEnum::toSelectArray();
        $digitalPrizeTypeEnum = DigitalPrizeTypeEnum::toSelectArray();
        $positionsEnum = PositionsEnum::toSelectArray();
        $eventsEnum = EventsEnum::toSelectArray();
        $allPrizePacks = $this->prizePackService->getAll();
        $badgeColors = BadgeColorEnum::toSelectArray();

        return view('admin.packages.edit', compact('package', 'yesNo', 'auctionTypesEnum', 'sealedBidDeadLinesEnum', 'moneyBackEnum', 'tiePreferenceEnum', 'formation', 'transferAuthority', 'agentTransferAfterEnum', 'digitalPrizeTypeEnum', 'positionsEnum', 'eventsEnum', 'allPrizePacks', 'badgeColors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Package $package)
    {
        $data = $request->all();
        $data['first_seal_bid_deadline'] = (! is_null(Arr::get($data, 'first_seal_bid_deadline')) ? carbon_set_db_date_time($data['first_seal_bid_deadline']) : null);
        $package = $this->service->update(
            $package,
            $data
        );

        if ($package) {
            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('admin.packages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        if ($package->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.packages.index');
    }
}
