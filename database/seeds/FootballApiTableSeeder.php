<?php

use Illuminate\Database\Seeder;

class FootballApiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('import:clubs');

        Artisan::call('import:players', [
            '--initial' => 'true',
        ]);

        // \DB::table('player_contracts')->where('position', 'Centre-back (CB)')->inRandomOrder()->limit(80)->update(['position' => 'Full-back (FB)']);

        DB::table('player_contracts')->update(['is_active' => 1]);

        Artisan::call('import:fixtures', [
            '--all' => 'true',
        ]);

        // Artisan::call('import:fixture-stats', [
        //     '--daterange' => now()->subDays(15)->toDateString().':'.now()->toDateString(),
        // ]);
    }
}
