<?php

namespace App\Fixtures\EventType;

use App\Fixtures\EventType\Type;
use App\Fixtures\TypeInterface;

class PenaltyMissed extends Type implements TypeInterface
{
    protected $field_settings = [
        'player_missed' => ['name'=>'player_missed', 'data'=>'player', 'input'=>'select', 'title'=>'Missed By', 'event'=>''],
    ];

    protected $points = 2;

    public function rules($key = ''): array
    {
        $rules = [
            'player_missed' => ['values'=>'club'],
        ];

        return (! empty($key) && ! empty($rules[$key])) ? $rules[$key] : $rules;
    }
}
