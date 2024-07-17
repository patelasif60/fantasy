<?php

namespace App\Repositories;

class FixtureEventDetailsRepository
{
    public function create($event)
    {
        $type = $event->eventType()->first()->class;
        $type_obj = new $type();
        $data = $type_obj->prepareForSave(request(), $event->event_type);
        $event->details()->createMany($data);

        return $event;
    }

    public function update($event)
    {
        $event->details()->delete();
        $type = $event->eventType()->first()->class;
        $type_obj = new $type();
        $data = $type_obj->prepareForSave(request(), $event->event_type);
        $event->details()->createMany($data);

        return $event;
    }
}
