<?php

namespace App\Fixtures\EventType;

use App\Fixtures\EventType\Type;
use App\Fixtures\TypeInterface;

class GoalkeeperSave extends Type implements TypeInterface
{
    protected $field_settings = [
        'player_goal_save'  => ['name'=>'player_goal_save', 'data'=>'player', 'input'=>'select', 'title'=>'Goalkeeper', 'event'=>''],
    ];

    protected $points = 2;

    public function rules($key = ''): array
    {
        $rules = [
            'player_goal_save'  => ['values'=>'club'],
        ];

        return (! empty($key) && ! empty($rules[$key])) ? $rules[$key] : $rules;
    }
}
