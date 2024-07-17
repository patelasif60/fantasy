<?php

namespace App\Fixtures\EventType;

use App\Fixtures\EventType\Type;
use App\Fixtures\TypeInterface;

class YellowCard extends Type implements TypeInterface
{
    protected $field_settings = [
        'player_off_yellow' => ['name'=>'player_off_yellow', 'data'=>'player', 'input'=>'select', 'title'=>'Player', 'event'=>''],
    ];

    protected $points = 2;

    public function rules($key = ''): array
    {
        $rules = [
            'player_off_yellow' => ['values'=>'club'],
        ];

        return (! empty($key) && ! empty($rules[$key])) ? $rules[$key] : $rules;
    }
}
