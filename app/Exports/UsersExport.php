<?php

namespace App\Exports;

use App\Repositories\UserRepository;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'First name',
            'Last name',
            'Email address',
            'Team ID',
            'League ID',
            'Chairman',
            'Co-Chairman',
            'News about game updates',
            'News from our partners',
            'Paid status',
            'League package',
            'League status',
            'Auction type',
            'Auction date',
        ];
    }

    public function collection()
    {
	ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');
        $repository = new UserRepository();

        return collect($repository->getConsumerTeamLeagueExports());
    }
}
