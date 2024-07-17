<?php

namespace App\Repositories;

use App\Enums\FixtureLineupTypesEnum;
use App\Models\FixtureLineup;
use App\Models\FixtureLineupPlayer;

class FixtureLineupRepository
{
    public function store($data, $fixture_id)
    {
        foreach ($data['formation'] as $club_id => $formation_id) {
            if ($formation_id) {
                $lineupData = $this->create([
                    'fixture_id'    =>  $fixture_id,
                    'lineup_type'   =>  FixtureLineupTypesEnum::getValue($data['lineup_type']),
                    'formation_id'  =>  $formation_id,
                    'club_id'       =>  $club_id,
                ]);

                if ($lineupData) {
                    foreach ($data['player'][$club_id] as $key => $player_id) {
                        if ($player_id) {
                            $splitData = $this->splitIdAndPosition($player_id);
                            if ($key > 10) {
                                $splitData['position'] = 'Substitute (SU)';
                            }

                            $lineupPlayer = $this->createPlayer([
                                'lineup_id'         => $lineupData['id'],
                                'player_id'         => $splitData['id'],
                                'lineup_position'   => $splitData['position'],
                            ]);
                        }
                    }
                }
            }
        }

        return ($lineupPlayer) ? true : false;
    }

    public function create($data)
    {
        return FixtureLineup::create(
            ['fixture_id'    =>  $data['fixture_id'],
                'lineup_type'   =>  $data['lineup_type'],
                'formation_id'  =>  $data['formation_id'],
                'club_id'       =>  $data['club_id'],
            ]
        );
    }

    public function createPlayer($data)
    {
        return FixtureLineupPlayer::create(
            [
                'lineup_id'        => $data['lineup_id'],
                'player_id'        => $data['player_id'],
                'lineup_position'  => $data['lineup_position'],
            ]
        );
    }

    public function splitIdAndPosition($string)
    {
        $splitData = explode('|', $string);
        $data['id'] = $splitData[0];
        $data['position'] = $splitData[1];

        return $data;
    }

    public function update($data, $fixture_id)
    {
        foreach ($data['formation'] as $club_id => $formation_id) {
            if ($formation_id) {
                $lineup = $this->getLineups(['club_id' => $club_id, 'lineup_type' => $data['lineup_type'], 'fixture_id' => $fixture_id])->all();
                if (! $lineup) { // create new lineup

                    $lineupData = $this->create([
                        'fixture_id'    =>  $fixture_id,
                        'lineup_type'   =>  FixtureLineupTypesEnum::getValue($data['lineup_type']),
                        'formation_id'  =>  $formation_id,
                        'club_id'       =>  $club_id,
                    ]);

                    if ($lineupData) {
                        foreach ($data['player'][$club_id] as $key => $player_id) {
                            if ($player_id) {
                                $splitData = $this->splitIdAndPosition($player_id);

                                if ($key > 10) {
                                    $splitData['position'] = 'Substitute (SU)';
                                }

                                $lineupPlayer = $this->createPlayer([
                                    'lineup_id'         => $lineupData['id'],
                                    'player_id'         => $splitData['id'],
                                    'lineup_position'   => $splitData['position'],
                                ]);
                                $playerData = $lineupPlayer;
                            }
                        }
                    }
                } else { // update
                    $lineup = $lineup[0];
                    $lineup->fill(['formation_id' => $formation_id]);
                    $lineup->save();
                    $lineup;

                    if ($lineup) {
                        foreach (array_filter($data['player'][$club_id]) as $key => $player_id) {
                            if ($player_id) {
                                $splitData = $this->splitIdAndPosition($player_id);
                                if ($key > 10) {
                                    $splitData['position'] = 'Substitute (SU)';
                                }

                                if (! isset($lineup['lineupPlayer'][$key])) {
                                    $lineupPlayer = $this->createPlayer([
                                        'lineup_id'         => $lineup['id'],
                                        'player_id'         => $splitData['id'],
                                        'lineup_position'   => $splitData['position'],
                                    ]);
                                    $playerData = $lineupPlayer;
                                } else {
                                    $lineup['lineupPlayer'][$key]->fill([
                                        'player_id'         => $splitData['id'],
                                        'lineup_position'   => $splitData['position'],
                                    ]);
                                    $lineup['lineupPlayer'][$key]->save();
                                    $playerData = $lineup;
                                }
                            }
                        }
                    }
                }
            } else {
                $fixtureLineup = FixtureLineup::where(['club_id'=>$club_id, 'fixture_id'=>$fixture_id])->first();
                if ($fixtureLineup) {
                    $fixtureLineup->delete();
                }
            }
        }

        return $playerData;
    }

    public function getLineupWithPlayers($fixture_id)
    {
        return FixtureLineup::where(['fixture_id' => $fixture_id])
           ->with(['lineupPlayer'=>function ($query) {
               $query->orderBy('id');
           }])
           ->get()
           ->groupBy('lineup_type');
    }

    public function getLineups($data)
    {
        return FixtureLineup::where([
            'fixture_id'  => $data['fixture_id'],
            'lineup_type' => FixtureLineupTypesEnum::getvalue($data['lineup_type']),
            'club_id'     => $data['club_id'],
        ])
        ->with(['lineupPlayer'=>function ($query) {
            $query->orderBy('id');
        }])
        ->get();
    }
}
