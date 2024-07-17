<?php

namespace App\Fixtures\EventType;

use App\Fixtures\EventType\Type;
use App\Fixtures\TypeInterface;

class RedCard extends Type implements TypeInterface
{
    protected $field_settings = [
        'player_off_red'    => ['name'=>'player_off_red', 'data'=>'player', 'input'=>'select', 'title'=>'Player Off', 'event'=>''],
    ];

    protected $points = 2;

    public function rules($key = ''): array
    {
        $rules = [
            'player_off_red'    => ['values'=>'club'],
        ];

        return (! empty($key) && ! empty($rules[$key])) ? $rules[$key] : $rules;
    }
}
