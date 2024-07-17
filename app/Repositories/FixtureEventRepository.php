<?php

namespace App\Repositories;

use App\Models\FixtureEvent;

class FixtureEventRepository
{
    public function create($data)
    {
        return FixtureEvent::create([
            'fixture_id'=>request()->fixture,
            'club_id'=>$data['club'],
            'event_type'=>$data['event_type'],
            'half'=>$data['half'],
            'minute'=>$data['minutes'].':'.$data['seconds'],
        ]);
    }

    public function update($event, $data)
    {
        $event->fill([
            'club_id'=>$data['club'],
            'event_type' => $data['event_type'],
            'half'=>$data['half'],
            'minute' => $data['minutes'].':'.$data['seconds'],
        ]);

        $event->save();

        return $event;
    }
}
