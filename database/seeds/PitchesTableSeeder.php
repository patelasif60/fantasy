<?php

use App\Models\Pitch;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PitchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        factory(Pitch::class, 2)->create()->each(function ($pitch) use ($faker) {
            $image = $faker->image(storage_path('temp_images'), 1080, 1578);
            if ($image) {
                $pitch->addMedia($image)->toMediaCollection('crest');
            } else {
                $pitch->addMediaFromUrl('https://loremflickr.com/1080/1578')->toMediaCollection('crest');
            }
        });
    }
}
