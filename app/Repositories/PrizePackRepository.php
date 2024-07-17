<?php

namespace App\Repositories;

use App\Models\PrizePack;
use Illuminate\Support\Arr;

class PrizePackRepository
{
    public function create($data)
    {
        $package = PrizePack::create([
            'name' => $data['name'],
            'price' => ! is_null(Arr::get($data, 'price')) ? $data['price'] : 0,
            'short_description' => Arr::get($data, 'short_description'),
            'long_description' => Arr::get($data, 'long_description'),
            'is_enabled' => Arr::get($data, 'is_enabled'),
            'is_default' => Arr::has($data, 'is_default'),
            'badge_color' => Arr::get($data, 'badge_color'),
        ]);

        return $package;
    }

    public function update($prizePack, $data)
    {
        $prizePack->fill([
            'name' => $data['name'],
            'price' => ! is_null(Arr::get($data, 'price')) ? $data['price'] : 0,
            'short_description' => Arr::get($data, 'short_description'),
            'long_description' => Arr::get($data, 'long_description'),
            'is_enabled' => Arr::get($data, 'is_enabled'),
            'is_default' => Arr::has($data, 'is_default'),
            'badge_color' => Arr::get($data, 'badge_color'),
        ])->save();

        return $prizePack;
    }

    public function getAll()
    {
        return PrizePack::orderBy('name')->pluck('name', 'id');
    }

    public function resetIsDefault($data)
    {
        if (Arr::get($data, 'is_default')) {
            PrizePack::where('is_default', 1)->update(['is_default' => 0]);
        }
    }
}
