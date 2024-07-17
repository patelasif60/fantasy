<?php

namespace App\Repositories;

use App\Enums\CustomCupStatusEnum;
use Illuminate\Support\Arr;

class CustomCupRepository
{
    public function create($division, $data)
    {
        $customCup = $division->customCup()->create([
            'name' => $data['name'],
            'is_bye_random' => Arr::get($data, 'is_bye_random', true),
            'status' => CustomCupStatusEnum::__default,
        ]);

        return $customCup;
    }

    public function update($customCup, $data)
    {
        $customCup->fill([
            'name' => $data['name'],
            'is_bye_random' => Arr::get($data, 'is_bye_random', true),
        ]);
        $customCup->save();

        return $customCup;
    }
}
