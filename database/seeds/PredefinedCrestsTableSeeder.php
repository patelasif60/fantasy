<?php

use App\Models\PredefinedCrest;
use Illuminate\Database\Seeder;

class PredefinedCrestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = File::allFiles(base_path().'/database/seeds/crests');
        foreach ($files as $file) {
            $crest = PredefinedCrest::create([
                'name' => $file->getBasename('.png'),
                'is_published' => 1,
            ]);
            $crest->addMedia($file->getPathname())->preservingOriginal()->toMediaCollection('crest');
        }
    }
}
