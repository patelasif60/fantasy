<?php

namespace App\Repositories;

use App\Models\FixtureEventType;
use App\Models\PlayerContract;

class FixtureEventTypeRepository
{
    public function get_types()
    {
        return FixtureEventType::all();
    }

    public function get_type_config()
    {
        $types = FixtureEventType::all();
        $type_config = [];
        foreach ($types as $key => $value) {
            $type_class = $value['class'];
            if (class_exists($type_class)) {
                $type_config[$value['id']] = new $type_class();
                $type_config[$value['id']]->setKey($value['key']);
            }
        }

        return $type_config;
    }

    public function getPlayersInContract($club_id, $fixture)
    {
        $match_date = $fixture->date_time;
        $players = PlayerContract::where('club_id', $club_id)
                    ->where('start_date', '<=', $match_date)
                    ->where(function ($query) use ($match_date) {
                        $query->where('end_date', '>=', $match_date)
                            ->orWhereNull('end_date');
                    })
                    ->whereRaw("FIND_IN_SET(player_id ,(SELECT GROUP_CONCAT(fixture_stats.`player_id`) FROM fixture_stats WHERE fixture_stats.`fixture_id`=$fixture->id AND fixture_stats.`appearance`>0))")
                    ->with(['player'=>function ($query) {
                        $query->select('id', 'first_name', 'last_name');
                    }])
                    ->get();

        return $players;
    }

    public function getFixturePlayers($fixture, $type = ['home', 'away'])
    {
        $data = [];
        if (in_array('home', $type)) {
            $data['home'] = $this->getPlayersInContract($fixture->home_club_id, $fixture);
        }
        if (in_array('away', $type)) {
            $data['away'] = $this->getPlayersInContract($fixture->away_club_id, $fixture);
        }

        return $data;
    }
}
