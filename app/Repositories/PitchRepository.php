<?php

namespace App\Repositories;

use App\Models\Pitch;
use Illuminate\Support\Arr;

class PitchRepository
{
    public function create($data)
    {
        $pitch = Pitch::create([
            'name' => $data['name'],
            'is_published' => Arr::has($data, 'is_published'),
        ]);

        return $pitch;
    }

    public function update($pitch, $data)
    {
        $pitch->fill([
            'name' => $data['name'],
            'is_published' => Arr::has($data, 'is_published'),
        ]);

        $pitch->save();

        return $pitch;
    }

    public function crestDestroy($pitch)
    {
        return $pitch->clearMediaCollection('pitch');
    }

    public function check($data)
    {
        $countQuery = Pitch::where([
            'name' => $data['name'],
        ]);

        if (isset($data['id'])) {
            $countQuery->where('id', '!=', $data['id']);
        }

        return $countQuery->count();
    }
}
