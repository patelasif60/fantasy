<?php

namespace App\Repositories;

use App\Models\PredefinedCrest;
use Illuminate\Support\Arr;

class PredefinedCrestRepository
{
    public function create($data)
    {
        return PredefinedCrest::create([
            'name' => $data['name'],
            'is_published' => Arr::get($data, 'is_published', false),
        ]);
    }

    public function update($crest, $data)
    {
        $crest->fill([
            'name' => $data['name'],
            'is_published' => Arr::get($data, 'is_published', false),
        ]);

        $crest->save();

        return $crest;
    }

    public function crestDestroy($crest)
    {
        return $crest->clearMediaCollection('crest');
    }

    public function check($data)
    {
        $countQuery = PredefinedCrest::where([
            'name' => $data['name'],
        ]);

        if (isset($data['id'])) {
            $countQuery->where('id', '!=', $data['id']);
        }

        return $countQuery->count();
    }
}
