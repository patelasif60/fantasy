<?php

namespace App\Console\Commands;

use App\Enums\EventsEnum;
use App\Enums\PositionsEnum;
use App\Models\Division;
use App\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TransferDivisionsFromCsv extends Command
{
    const STARTER = 'Pro 19/20';
    const SOCIAL = 'Social 19/20';
    const EXCEPT_STARTER = 'Legend 19/20';
    const AUCTION_DATE = '2019-08-01 00:00:00';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:divisions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to migrate divisions from CSV file to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Migration of divisions started');

        if (($handle = fopen(database_path().'/seeds/files/transfer_divisions.csv', 'r')) !== false) {
            $flag = true;

            $divisionIdMapping = [];
            $tempArray[0] = 'CSVID';
            $tempArray[1] = 'DBID';
            $divisionIdMapping[] = $tempArray;
            $leagueInfo = [];
            $packages = [];

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $chairmanId = $this->getLeagueCharimanIdFromCsv($data[1]);

                if (! $chairmanId) {
                    info('LeagueId does not have chairman.', ['leagueId' => $data[1]]);
                    continue;
                }

                $package = $this->getPackageId($data[4], $data[0]);

                if (! $package) {
                    info('LeagueId does not have package.', ['leagueId' => $data[2]]);
                    continue;
                }

                $leagueInfo[$data[1]][] = $data[2];

                $division = Division::create([
                    'name' => string_preg_replace($data[2]),
                    'chairman_id' => $chairmanId,
                    'package_id' => $package->id,
                    'parent_division_id' => null,
                    'uuid' => (string) Str::uuid(),
                    'auction_date' => self::AUCTION_DATE,
                    'auctioneer_id' => $chairmanId,
                    'is_legacy' => true,
                    'is_viewed_package_selection' => true,
                ]);

                $tempArray[0] = $data[0];
                $tempArray[1] = $division->id;
                $divisionIdMapping[] = $tempArray;

                $this->storeCoChairman($division, $data[3], $data[5]);
                $this->storeDivisionPoints($division);
            }

            fclose($handle);

            $this->createDivisionMappingCsv($divisionIdMapping);
            $this->assignParentLeagueId($leagueInfo);
            $this->info('Migration of divisions completed');
        }
    }

    private function getLeagueCharimanIdFromCsv($leagueId)
    {
        if (($handles = fopen(database_path().'/seeds/files/transfer_division_chairman.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handles, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                if ($data[0] == $leagueId) {
                    return $this->getLeagueCharimanIdFromMapCsv($data[1]);
                }
            }

            fclose($handles);
        }
    }

    private function getLeagueCharimanIdFromMapCsv($csvId)
    {
        if (($handles = fopen(database_path().'/seeds/files/transfer_user_id_map.csv', 'r')) !== false) {
            $flag = true;
            while (($data = fgetcsv($handles, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                if ($data[0] == $csvId) {
                    return $data[1];
                }
            }

            fclose($handles);
        }
    }

    private function assignParentLeagueId($leagueInfo)
    {
        foreach ($leagueInfo as $key => $value) {
            if (count($value) > 1) {
                $division = Division::where('name', $value[0])->first();
                if ($division) {
                    array_shift($value);
                    Division::whereIn('name', $value)
                        ->update(['parent_division_id' => $division->id]);
                } else {
                    $division = Division::where('name', $value[0])->get();
                }
            }
        }
    }

    private function getPackageId($packageId, $divisionId)
    {
        if ($packageId != 107) {
            $packageName = self::EXCEPT_STARTER;
        } else {
            $packageName = self::STARTER;
            if ($divisionId >= 61443 && $divisionId <= 61449) {
                $packageName = self::SOCIAL;
            }
        }

        return Package::where('name', $packageName)->first();
    }

    private function storeCoChairman($division, $coChairmenId1, $coChairmenId2)
    {
        $coChairmenId = [];
        if ($coChairmenId1 != 'NULL') {
            $chairmanId = $this->getLeagueCharimanIdFromMapCsv($coChairmenId1);

            if ($chairmanId) {
                $coChairmenId[] = $chairmanId;
            }
        }

        if ($coChairmenId2 != 'NULL') {
            $chairmanId = $this->getLeagueCharimanIdFromMapCsv($coChairmenId2);

            if ($chairmanId) {
                $coChairmenId[] = $chairmanId;
            }
        }

        if ($coChairmenId) {
            $division->coChairmen()->attach($coChairmenId);
        }
    }

    private function storeDivisionPoints($division)
    {
        $events = EventsEnum::toSelectArray();
        $positions = PositionsEnum::toSelectArray();
        $divisionPoint = [];
        foreach ($events as $eventKey => $eventValue) {
            $tempData = [];
            foreach ($positions as $positionKey => $positionValue) {
                $tempData['events'] = $eventKey;
                $tempData[$positionKey] = null;
            }
            array_push($divisionPoint, $tempData);
        }
        $division->divisionPoints()->createMany($divisionPoint);
    }

    private function createDivisionMappingCsv($divisionIdMapping)
    {
        $filename = database_path().'/seeds/files/transfer_division_id_map.csv';
        $handle = fopen($filename, 'w+');
        foreach ($divisionIdMapping as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
    }
}
