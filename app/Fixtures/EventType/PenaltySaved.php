<?php

namespace App\Fixtures\EventType;

use App\Fixtures\EventType\Type;
use App\Fixtures\TypeInterface;

class PenaltySaved extends Type implements TypeInterface
{
    protected $field_settings = [
        'player_saved'  => ['name'=>'player_saved', 'data'=>'player_saved', 'input'=>'select', 'title'=>'Saved By', 'event'=>''],
    ];

    protected $points = 1;

    public function rules($key = ''): array
    {
        $rules = [
            'player_saved'  => ['values'=>'club'],
        ];

        return (! empty($key) && ! empty($rules[$key])) ? $rules[$key] : $rules;
    }
}
