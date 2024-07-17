<?php

namespace App\Repositories;

use App\Models\PlayerStatus;

class PlayerStatusRepository
{
    public function create($data)
    {
        $create_array = [
            'player_id' => $data['player_id'],
            'status'=>$data['status'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
        ];
        if (! empty($data['end_date'])) {
            $create_array['end_date'] = $data['end_date'];
        } else {
            $create_array['end_date'] = null;
        }

        return PlayerStatus::create($create_array);
    }

    public function update($playerstatus, $data)
    {
        $update_array = [
            'status'=>$data['status'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
        ];
        if (! empty($data['end_date'])) {
            $update_array['end_date'] = $data['end_date'];
        } else {
            $update_array['end_date'] = null;
        }
        $playerstatus->fill($update_array);

        $playerstatus->save();

        return $playerstatus;
    }
}
