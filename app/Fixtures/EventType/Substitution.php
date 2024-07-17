<?php

namespace App\Fixtures\EventType;

use App\Fixtures\EventType\Type;
use App\Fixtures\TypeInterface;

class Substitution extends Type implements TypeInterface
{
    protected $field_settings = [
        'player_on_sub'     => ['name'=>'player_on_sub', 'data'=>'player', 'input'=>'select', 'title'=>'Player On', 'event'=>'change_affect_all'],
        'player_off_sub'    => ['name'=>'player_off_sub', 'data'=>'player', 'input'=>'select', 'title'=>'Player Off', 'event'=>'change_affect_all'],
    ];

    protected $points = 1;

    public function rules($key = ''): array
    {
        $rules = [
            'player_off_sub'    => ['values'=>'club', 'validation'=>['not_in'=>['player_on_sub']]],
            'player_on_sub'     => ['values'=>'club', 'validation'=>['not_in'=>['player_off_sub']]],
        ];

        return (! empty($key) && ! empty($rules[$key])) ? $rules[$key] : $rules;
    }
}
