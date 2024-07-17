<?php

namespace App;

class FantasyLeague
{
    public static function getJavascriptVariables()
    {
        return [
            'division' => request()->route()->parameter('division'),
            'division_id' => is_object(request()->route()->parameter('division')) ? request()->route()->parameter('division')->id : request()->route()->parameter('division'),
            'currentRoute' => request()->route()->getName(),
        ];
    }
}
