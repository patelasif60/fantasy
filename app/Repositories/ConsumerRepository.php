<?php

namespace App\Repositories;

use Illuminate\Support\Arr;

class ConsumerRepository
{
    public function create($user, $data)
    {
        $consumer = $user->consumer()->create([
            'dob' => Arr::get($data, 'dob'),
            'address_1' => Arr::get($data, 'address_1'),
            'address_2' => Arr::get($data, 'address_2'),
            'town' => Arr::get($data, 'town'),
            'county' => Arr::get($data, 'county'),
            'post_code' => $data['post_code'],
            'country' => Arr::get($data, 'country'),
            'country_code' => Arr::get($data, 'country_code'),
            'telephone' => Arr::get($data, 'telephone'),
            'favourite_club' => Arr::get($data, 'favourite_club'),
            'introduction' => Arr::get($data, 'introduction'),
            'has_games_news' => Arr::get($data, 'has_games_news', false),
            'has_third_parities' => Arr::get($data, 'has_third_parities', false),
        ]);

        return $consumer;
    }

    public function storeBasicDetails($user, $data)
    {
        $consumer = $user->consumer()->create([
            'has_games_news' => Arr::get($data, 'has_games_news', false),
            'has_third_parities' => Arr::get($data, 'has_third_parities', false),
        ]);

        return $consumer;
    }

    public function update($consumer, $data)
    {
        $consumer->fill([
            'dob' => $data['dob'],
            'address_1' => Arr::get($data, 'address_1'),
            'address_2' => Arr::get($data, 'address_2'),
            'town' => Arr::get($data, 'town'),
            'county' => Arr::get($data, 'county'),
            'post_code' => Arr::get($data, 'post_code'),
            'country' => Arr::get($data, 'country'),
            'favourite_club' => Arr::get($data, 'favourite_club'),
            'introduction' => Arr::get($data, 'introduction'),
            'country_code' => Arr::get($data, 'country_code'),
            'telephone' => Arr::get($data, 'telephone'),
            'has_games_news' => Arr::get($data, 'has_games_news', false),
            'has_third_parities' => Arr::get($data, 'has_third_parities', false),
        ]);

        $consumer->save();

        return $consumer;
    }

    public function updateBasicDetails($consumer, $data)
    {
        $consumer->fill([
            'has_games_news' => Arr::get($data, 'has_games_news', false),
            'has_third_parities' => Arr::get($data, 'has_third_parities', false),
        ]);

        $consumer->save();

        return $consumer;
    }

    public function avatarDestroy($consumer)
    {
        return $consumer->clearMediaCollection('avatar');
    }

    public function createConsumer($user, $data)
    {
        $this->storeBasicDetails($user, $data);
    }
}
