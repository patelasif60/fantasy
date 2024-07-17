<?php

namespace App\Repositories;

use App\Models\Club;
use Illuminate\Support\Arr;

class ClubRepository
{
    public function create($data)
    {
        return Club::create([
            'name' => $data['name'],
            'api_id' => $data['api_id'],
            'short_name' => $data['short_name'],
            'short_code' => $data['short_code'],
            'is_premier' => Arr::has($data, 'is_premier'),
        ]);
    }

    public function update($club, $data)
    {
        $club->fill([
            'name' => $data['name'],
            'api_id' => $data['api_id'],
            'short_name' => $data['short_name'],
            'short_code' => $data['short_code'],
            'is_premier' => Arr::has($data, 'is_premier'),
        ]);

        $club->save();

        return $club;
    }

    public function getClubs($where = [])
    {
        if (empty($where)) {
            return Club::orderBy('name');
        }

        return Club::where($where)->orderBy('name')->get();
    }

    public function getClubsOrderByShortCode($where = [])
    {
        if (empty($where)) {
            return Club::orderBy('short_code', 'asc');
        }

        return Club::where($where)->orderBy('short_code', 'asc')->get();
    }

    public function crestDestroy($club)
    {
        return $club->clearMediaCollection('crest');
    }

    public function list()
    {
        return Club::select(['id', 'name'])->get();
    }

    public function listWithShortCode()
    {
        return Club::select(['id', 'name', 'short_code'])->premier()->orderBy('short_code')->get();
    }
}
