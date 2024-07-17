<?php

namespace App\Repositories;

class FeedCountRepository
{
    public function getUnreadCount($consumer)
    {
        $feedCount = $consumer->feedCount;

        if ($feedCount) {
            return $feedCount->count;
        }

        return $this->create($consumer)->count;
    }

    public function create($consumer)
    {
        $feedCount = $consumer->feedCount()->create([
            'count' => 0,
        ]);

        return $feedCount;
    }

    public function update($consumer, $count)
    {
        $feedCount = $consumer->feedCount->update([
            'count' => $count,
        ]);

        return $feedCount;
    }
}
