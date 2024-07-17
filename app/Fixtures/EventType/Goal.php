<?php

namespace App\Fixtures\EventType;

use App\Fixtures\EventType\Type;
use App\Fixtures\TypeInterface;

class Goal extends Type implements TypeInterface
{
    protected $field_settings = [
        'scorer'    => ['name'=>'scorer', 'data'=>'player', 'input'=>'select', 'title'=>'Scorer', 'event'=>'change_affect_all'],
        'assist'    => ['name'=>'assist', 'data'=>'player', 'input'=>'select', 'title'=>'Assist', 'event'=>'change_affect_all'],
        'assist2'   => ['name'=>'assist2', 'data'=>'player', 'input'=>'select', 'title'=>'Assist2', 'event'=>'change_affect_all'],
        'assist3'   => ['name'=>'assist3', 'data'=>'player', 'input'=>'select', 'title'=>'Assist3', 'event'=>'change_affect_all'],
    ];

    protected $points = 3;

    public function rules($key = ''): array
    {
        $rules = [
            'scorer'    => ['values'=>'club', 'validation'=>['not_in'=>['assist', 'assist2', 'assist3']]],
            'assist'    => ['values'=>'club', 'validation'=>['not_in'=>['assist2', 'assist3', 'scorer']]],
            'assist2'   => ['values'=>'club', 'validation'=>['not_in'=>['assist', 'assist3', 'scorer']]],
            'assist3'   => ['values'=>'club', 'validation'=>['not_in'=>['assist', 'assist2', 'scorer']]],
        ];

        return (! empty($key) && ! empty($rules[$key])) ? $rules[$key] : $rules;
    }
}
