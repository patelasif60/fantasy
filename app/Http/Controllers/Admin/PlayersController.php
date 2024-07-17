<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PlayersDataTable;
use App\Enums\PlayerContractPositionEnum;
use App\Enums\PlayerStatusNoDateEnum;
use App\Http\Requests\Player\StoreRequest;
use App\Http\Requests\Player\UpdateRequest;
use App\Models\Player;
use App\Services\PlayerService;
use JavaScript;

class PlayersController extends Controller
{
    /**
     * @var PlayerService
     */
    protected $service;

    /**
     * PlayersController constructor.
     *
     * @param PlayerService $service
     */
    public function __construct(PlayerService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = $this->service->getClubs();
        $positions = PlayerContractPositionEnum::getValues();

        return view('admin.players.index', compact('clubs', 'positions'));
    }

    /**
     * Fetch the players data for datatable.
     *
     * @param PlayersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(PlayersDataTable $dataTable)
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
        Javascript::put([
            'not_end_date' => PlayerStatusNoDateEnum::getValues(),
        ]);

        return view('admin.players.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $player = $this->service->create($request->all());

        if ($player) {
            if ($request->hasFile('player_image')) {
                $player_image = $player->addMediaFromRequest('player_image');
                if ($crop = $request->imageshouldBeCropped('player_image')) {
                    $player_image->withManipulations([
                        'thumb' => [
                            'manualCrop' => $request->getCropParameters($crop),
                        ],
                    ]);
                }
                $player_image->toMediaCollection('player_image');
            }

            flash(__('messages.data.saved.success'))->success();
        } else {
            flash(__('messages.data.saved.error'))->error();
        }

        return redirect()->route('admin.players.edit', $player);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        $playerImageObject = $player->getMedia('player_image')->last();

        $playerImage = '';
        if ($playerImageObject) {
            $playerImage = [
                'name' => $playerImageObject->file_name,
                'type' => $playerImageObject->mime_type,
                'size' => $playerImageObject->size,
                'file' => $playerImageObject->getUrl('thumb'),
                'data' => [
                    'url' => $playerImageObject->getUrl('thumb'),
                    'id' => $playerImageObject->id,
                ],
            ];
            $playerImage = json_encode($playerImage);
        }

        Javascript::put([
            'not_end_date' => PlayerStatusNoDateEnum::getValues(),
        ]);

        return view('admin.players.edit', compact('player', 'playerImage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Player $player)
    {
        $player = $this->service->update(
            $player,
            $request->all()
        );

        if ($player) {
            if ($request->hasFile('player_image')) {
                $player_image = $player->addMediaFromRequest('player_image');
                if ($crop = $request->imageshouldBeCropped('player_image')) {
                    $player_image->withManipulations([
                        'thumb' => [
                            'manualCrop' => $request->getCropParameters($crop),
                        ],
                    ]);
                }
                $player_image->toMediaCollection('player_image');
            } else {
                $returnVal = $request->imageShouldBeDeleted('player_image');
                if ($returnVal) {
                    $this->service->playerImageDestroy($player);
                }
            }

            flash(__('messages.data.updated.success'))->success();
        } else {
            flash(__('messages.data.updated.error'))->error();
        }

        return redirect()->route('admin.players.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        if ($player->delete()) {
            flash(__('messages.data.deleted.success'))->success();
        } else {
            flash(__('messages.data.deleted.error'))->error();
        }

        return redirect()->route('admin.players.index');
    }
}
