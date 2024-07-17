<?php

namespace App\Fixtures\EventType;

use App\Fixtures\EventType\Type;
use App\Fixtures\TypeInterface;

class OwnGoal extends Type implements TypeInterface
{
    protected $field_settings = [
        'own_scorer'    => ['name'=>'own_scorer', 'data'=>'player', 'input'=>'select', 'title'=>'Scorer', 'event'=>'change_affect_all'],
        'own_assist'    => ['name'=>'own_assist', 'data'=>'player', 'input'=>'select', 'title'=>'Assist', 'event'=>'change_affect_all'],
    ];

    protected $points = 3;

    public function rules($key = ''): array
    {
        $rules = [
            'own_scorer'    => ['values'=>'club', 'validation'=>['not_in'=>['own_assist']]],
            'own_assist'    => ['values'=>'club', 'validation'=>['not_in'=>['own_scorer']]],
        ];

        return (! empty($key) && ! empty($rules[$key])) ? $rules[$key] : $rules;
    }
}
