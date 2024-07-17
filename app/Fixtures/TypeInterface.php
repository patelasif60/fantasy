<?php

namespace App\Fixtures;

// Interface to bind all the types of the event_type class
interface TypeInterface
{
    //Bind Functions
    public function rules($key = ''): array;

    public function getFieldSettings();

    public function setKey($key);

    public function getKey();

    public function getHtml($field, $event_clubs);
}
