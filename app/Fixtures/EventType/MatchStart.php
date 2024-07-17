<?php

namespace App\Fixtures\EventType;

use App\Fixtures\EventType\Type;
use App\Fixtures\TypeInterface;

class MatchStart extends Type implements TypeInterface
{
    protected $field_settings = [];

    public function rules($key = ''): array
    {
        return [];
    }
}
