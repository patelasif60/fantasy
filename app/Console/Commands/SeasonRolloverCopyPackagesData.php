<?php

namespace App\Console\Commands;

use App\Models\Package;
use Illuminate\Console\Command;

class SeasonRolloverCopyPackagesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollover:package-copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Packages copy from old season to new season';

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
        $season_year = date('Y') . '/' . (date('y') + 1);

        $packages = Package::where('is_enabled', 'Yes')->get();

        if(!$packages) {
            $this->info('No packages found please check is_enabled flag in packages table');
            return ;
        }

        foreach ($packages as $package) {

            if($package->display_name == 'Legend') {
                $newPackage = $this->store($package, $package->display_name.' '.$season_year, $package->display_name, $package->id, $package->free_placce_for_new_user);
            }

            if($package->display_name == 'Novice') {

                foreach (['Novice' => 'Novice '.$season_year.'', 'Pro' => 'Pro '.$season_year.''] as $key => $pk) {
                    $copy_from = $package->id;
                    $free_placce_for_new_user = $package->free_placce_for_new_user;
                    if($key == 'Pro') {
                        $find = $packages->where('display_name',$key)->first();
                        $free_placce_for_new_user = 'No';
                        $copy_from = $find->id;
                    }
                    $newPackage = $this->store($package, $pk, $key, $copy_from, $free_placce_for_new_user);
                }
            }

            if($package->display_name == 'Social League') {
                
                $newPackage = $this->store($package, $package->display_name.' '.$season_year, $package->display_name, $package->id, $package->free_placce_for_new_user);
            }

            $package->is_enabled = 'No';
            $package->save();

        }
    }

    public function store($package, $name, $display_name, $copy_from, $free_placce_for_new_user)
    {
        $newPackage = $package->replicate();
        $newPackage->name = $name;
        $newPackage->display_name = $display_name;
        $newPackage->free_placce_for_new_user = $free_placce_for_new_user;
        $newPackage->copy_from = $copy_from;
        $newPackage->price = ($display_name == 'Pro') ? 20 : $newPackage->price;
        $newPackage->save();

        foreach ($package->packagePoints as $point) {
            $newPoint = $point->replicate();
            $newPoint->package_id = $newPackage->id;
            $newPoint->save();
        }

        $this->info('New created package '.$newPackage->name);

        return $newPackage;
    }
}
