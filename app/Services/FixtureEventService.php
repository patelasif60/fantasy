<?php

namespace App\Services;

use App\Enums\FixtureEventHalfEnum;
use App\Repositories\FixtureEventDetailsRepository;
use App\Repositories\FixtureEventRepository;
use App\Repositories\FixtureEventTypeRepository;
use JavaScript;

class FixtureEventService
{
    /**
     * The user repository instance.
     *
     * @var FixtureEventRepository
     */
    protected $repository;

    protected $event_details;

    protected $event_type;

    /**
     * Create a new service instance.
     *
     * @param FixtureEventRepository $repository
     * @param FixtureEventDetailsRepository $event_details
     * @param FixtureEventTypeRepository $event_type
     */
    public function __construct(FixtureEventRepository $repository, FixtureEventDetailsRepository $event_details, FixtureEventTypeRepository $event_type)
    {
        $this->repository = $repository;
        $this->event_details = $event_details;
        $this->event_type = $event_type;
    }

    public function prepare_event_data($fixture, $js = false, $event = [])
    {
        $data['event_type_config'] = $this->event_type->get_type_config();
        $data['event_type_rules'] = collect($data['event_type_config'])->mapWithKeys(function ($item) {
            return [$item->getKey()=>$item->rules()];
        })->all();
        $data['event_data'] = $this->event_type->getFixturePlayers($fixture);

        if ($js) {
            $data['clubs'] = [
                $fixture->home_team()->first()->id =>'home',
                $fixture->away_team()->first()->id => 'away',
            ];

            $player_data = [
                'home'=> $data['event_data']['home']->map(function ($item) {
                    return ['id'=>$item->player->id, 'text'=>$item->player->full_name];
                })->all(),
                'away'=> $data['event_data']['away']->map(function ($item) {
                    return ['id'=>$item->player->id, 'text'=>$item->player->full_name];
                })->all(),
            ];
            JavaScript::put([
                'clubs'             => $data['clubs'],
                'event_config'      => json_encode($data['event_type_config']),
                'event_type_rules'  => $data['event_type_rules'],
                'player_data'       => $player_data,
                'half_types'        => FixtureEventHalfEnum::toSelectArray(),
            ]);
        } else {
            $event_types = $this->event_type->get_types();
            $data['clubs'] = collect([
                $fixture->home_team()->first(),
                $fixture->away_team()->first(),
            ]);
            $data['event_types'] = $event_types->pluck('name', 'id')->all();
            $data['half_types'] = FixtureEventHalfEnum::toSelectArray();
            $data['fixture'] = $fixture;
            $data['event_keys'] = $event_types->mapWithKeys(function ($item) {
                return [$item->id => ['data-key' => $item->key]];
            })->all();
        }
        if (! empty($event)) {
            $data['event'] = $event;
            $data['event_type'] = $event->eventType()->first();
            $data['event_club'] = $event->club()->first();

            if ($data['event_club']->id == $data['clubs'][0]->id) {
                $data['event_club']->type = 'home';
                $data['clubs'][0]->type = 'home';
                $data['clubs'][1]->type = 'away';
            } else {
                $data['event_club']->type = 'away';
                $data['clubs'][0]->type = 'home';
                $data['clubs'][1]->type = 'away';
            }
            $data['event_details'] = $event->details()->get();
        }

        return $data;
    }

    public function create($event)
    {
        $event = $this->repository->create($event);
        $this->event_details->create($event);

        return $event;
    }

    public function update($event, $data)
    {
        $event = $this->repository->update($event, $data);
        $this->event_details->update($event);

        return $event;
    }
}
