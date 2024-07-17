<?php

namespace App\Services;

use App\Enums\EventsEnum;
use App\Jobs\TeamPointsRecalculateJob;
use App\Models\CmdSetting;
use App\Models\FixtureStats;
use App\Repositories\FixtureStatsRepository;

class FixtureStatService
{
    /**
     * The FixtureStats repository instance.
     *
     * @var FixtureStatsRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param FixtureStatsRepository $repository
     */
    public function __construct(FixtureStatsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateFixtureStatBeforeDelete($event)
    {
        foreach ($event->details as $detail) {
            $fixtureStat = $this->repository->getFixtureStatByFixture($event->fixture_id, $detail->field_value);

            if ($fixtureStat) {
                $action = 'minus';
                $this->updatePoints($event, $fixtureStat, $detail, $action);
            }
        }

        return true;
    }

    public function updatePoints($event, $fixtureStat, $detail, $action = null)
    {
        $column = '';
        if ($event->eventType->key === EventsEnum::GOAL) {
            if ($detail->field === 'scorer') {
                $column = 'goal';
            } else {
                $column = 'assist';
            }
        }

        if ($event->eventType->key === EventsEnum::OWN_GOAL) {
            if ($detail->field === 'own_scorer') {
                $column = 'own_goal';
            } else {
                $column = 'assist';
            }
        }

        if ($event->eventType->key === EventsEnum::YELLOW_CARD) {
            $column = 'yellow_card';
        }

        if ($event->eventType->key === EventsEnum::RED_CARD) {
            $column = 'red_card';
        }

        if ($column !== '') {
            if ($action == 'add') {
                $value = $fixtureStat->$column + 1;
            } else {
                $value = $fixtureStat->$column - 1;
            }

            $is_updated = $fixtureStat->is_updated ? $fixtureStat->is_updated : [];
            array_push($is_updated, $column);

            $fixtureStat->is_updated = array_unique($is_updated);
            $fixtureStat->$column = $value > 0 ? $value : 0;
            $fixtureStat->save();

            info('Update Points For');
            info('Event => '.$column);
            info('Point => '.$fixtureStat->$column);
            info('Fxiture stat id => '.$fixtureStat->id);

            // TeamPointsRecalculateJob::dispatch($fixtureStat);

            unset($command);
            $command['type'] = 'recalculate_points';
            $command['command'] = 'recalculate:points';
            $command['payload'] = json_encode(['fixture_stats' => $fixtureStat->id]);

            $response = CmdSetting::create($command);
        }

        return $fixtureStat;
    }

    public function createPoints($event, $detail)
    {
        $column = '';
        if ($event->eventType->key === EventsEnum::GOAL) {
            if ($detail->field === 'scorer') {
                $column = 'goal';
            } else {
                $column = 'assist';
            }
        }

        if ($event->eventType->key === EventsEnum::OWN_GOAL) {
            if ($detail->field === 'own_scorer') {
                $column = 'own_goal';
            } else {
                $column = 'assist';
            }
        }

        if ($event->eventType->key === EventsEnum::YELLOW_CARD) {
            $column = 'yellow_card';
        }

        if ($event->eventType->key === EventsEnum::RED_CARD) {
            $column = 'red_card';
        }

        if ($column !== '') {
            $is_updated = [];
            array_push($is_updated, $column);

            $fixtureStat = new FixtureStats;
            $fixtureStat->fixture_id = $event->fixture->id;
            $fixtureStat->fixture_api_id = $event->fixture->api_id;
            $fixtureStat->player_id = $detail->player->id;
            $fixtureStat->player_api_id = $detail->player->api_id;
            $fixtureStat->is_updated = $is_updated;
            $fixtureStat->$column = 1;
            $fixtureStat->save();

            info('Update Points For');
            info('Event => '.$column);
            info('Point => '.$fixtureStat->$column);
            info('Fxiture stat id => '.$fixtureStat->id);

            // TeamPointsRecalculateJob::dispatch($fixtureStat);

            unset($command);
            $command['type'] = 'recalculate_points';
            $command['command'] = 'recalculate:points';
            $command['payload'] = json_encode(['fixture_stats' => $fixtureStat->id]);

            $response = CmdSetting::create($command);
        }

        return $fixtureStat;
    }

    public function createFixtureStatAfterStore($event)
    {
        $action = 'add';
        foreach ($event->details as $detail) {
            $fixtureStat = $this->repository->getFixtureStatByFixture($event->fixture_id, $detail->field_value);

            if ($fixtureStat) {
                $this->updatePoints($event, $fixtureStat, $detail, $action);
            } else {
                $this->createPoints($event, $detail);
            }
        }

        return true;
    }

    public function isEventUpdate($event, $data)
    {
        $flag = false;
        $action = 'minus';
        if ($data['event_type'] !== $event->event_type) {
            foreach ($event->details as $detail) {
                $fixtureStat = $this->repository->getFixtureStatByFixture($event->fixture_id, $detail->field_value);

                if ($fixtureStat) {
                    $this->updatePoints($event, $fixtureStat, $detail, $action);
                    $flag = true;
                }
            }
        }

        return $flag;
    }

    public function isPlayerUpdate($event, $eventDetailsOld)
    {
        $eventDetailsNew = $event->details;
        $action = 'minus';
        foreach ($eventDetailsOld as $detail) {
            $fieldCount = $eventDetailsNew->where('field', $detail->field)->count();
            $fieldValueCount = $eventDetailsNew->where('field_value', $detail->field_value)->count();

            if ($fieldCount < 0 && $fieldValueCount < 0) {
                $fixtureStat = $this->repository->getFixtureStatByFixture($event->fixture_id, $detail->field_value);

                if ($fixtureStat) {
                    $this->updatePoints($event, $fixtureStat, $detail, $action);
                }
            }
        }

        return true;
    }
}
