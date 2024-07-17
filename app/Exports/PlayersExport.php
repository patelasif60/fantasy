<?php

namespace App\Exports;

use App\Repositories\PlayerRepository;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PlayersExport implements FromView, WithTitle
{
    private $division;

    private $positions;

    public function __construct($division, $positions)
    {
        $this->division = $division;
        $this->positions = $positions;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        $repository = new PlayerRepository();

        $date = now()->format('D, d M');
        $name = 'Player List - '.config('app.name');
        $data = $repository->getAllPlayersWithPointsCalculation($this->division);

        $header = view('manager.more.excel.header', ['updated_date'=>$date]);
        $pages[] = view('manager.more.excel.position', ['data'=> $data, 'positions' => $this->positions]);

        return view('manager.more.excel.index', ['pages' => $pages, 'header'=> $header]);
    }

    public function title(): string
    {
        return 'Auction Player List';
    }
}
