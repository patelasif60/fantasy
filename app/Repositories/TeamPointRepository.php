<?php

namespace App\Repositories;

use App\Models\TeamPoint;

class TeamPointRepository
{
    public function create($data)
    {
        return TeamPoint::create($data);
    }

    public function checkNewEvent($createdDate, $updatedDate, $fixtureEventId, $type)
    {
        if ($type == 'player') {
            $eventLogs = LogsTeamPlayerPoint::where('fixture_event_id', $fixtureEventId);
        } elseif ($type == 'team') {
            $eventLogs = LogsTeamPoint::where('fixture_event_id', $fixtureEventId);
        }

        if ($eventLogs->count() > 0) {
            $latestEventDate = $eventLogs->max('created_at');

            $createdDate = Carbon::parse($createdDate);
            $updatedDate = Carbon::parse($updatedDate);

            $pointsUpdatedDate = Carbon::parse($latestEventDate);

            return $createdDate->greaterThan($pointsUpdatedDate) &&
                $updatedDate->greaterThan($pointsUpdatedDate);
        } else {
            return true;
        }
    }
}
