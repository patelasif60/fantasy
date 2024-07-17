<?php

namespace App\Repositories;

use App\Models\ChildLinkedLeague;
use App\Models\Division;
use App\Models\ParentLinkedLeague;

class LinkedLeagueRepository
{
    public function getLinkedLeagues($division)
    {
        $parentLeagues = ParentLinkedLeague::join('divisions', 'divisions.id', '=', 'parent_linked_leagues.division_id')
            ->join('consumers', 'consumers.id', '=', 'divisions.chairman_id')
            ->leftJoin('users', 'users.id', '=', 'consumers.user_id')

            ->select('parent_linked_leagues.id as parent_linked_league_id', 'parent_linked_leagues.name', 'consumers.id as consumer_id', 'users.first_name', 'users.last_name')
            ->where('parent_linked_leagues.division_id', $division->id)
            ->get();

        $childLeagues = ChildLinkedLeague::join('parent_linked_leagues', 'child_linked_leagues.parent_linked_league_id', '=', 'parent_linked_leagues.id')

            ->join('divisions', 'divisions.id', '=', 'parent_linked_leagues.division_id')
            ->join('consumers', 'consumers.id', '=', 'divisions.chairman_id')
            ->leftJoin('users', 'users.id', '=', 'consumers.user_id')

            ->select('parent_linked_leagues.id as parent_linked_league_id', 'parent_linked_leagues.name', 'consumers.id as consumer_id', 'users.first_name', 'users.last_name')
            ->where('child_linked_leagues.division_id', $division->id)
            ->get();

        return $parentLeagues->concat($childLeagues);
    }

    public function getSearchLeagueResults($division, $data, $linkedLeague)
    {
        return Division::with(['consumer' => function ($query) {
            $query->with('user');
        },
        ])
                ->where(function ($query) use ($data) {
                    $query->where('name', 'like', '%'.escape_like($data['search_league']).'%')
                        ->orWhere('id', 'like', '%'.escape_like($data['search_league']).'%');
                })
                ->whereNotIn('id', $linkedLeague)
                ->where('id', '!=', $division->id)
                ->get();
    }

    public function getLeagueData($selectedLeagues)
    {
        return Division::with(['consumer' => function ($query) {
            $query->with('user');
        },
        ])
                ->whereIn('id', $selectedLeagues)
                ->get();
    }

    public function store($division, $data)
    {
        $parentLinkedLeague = ParentLinkedLeague::create([
            'division_id' => $division->id,
            'name' => $data['name'],
        ]);

        $linkedLeague = session('linkedLeague');
        $selecedLeagues = $linkedLeague[$division->id];

        $childLinkedLeague = [];
        foreach ($selecedLeagues as $key => $value) {
            $tempData = [];
            $tempData['parent_linked_league_id'] = $parentLinkedLeague->id;
            $tempData['division_id'] = $value;
            $tempData['created_at'] = now();
            $tempData['updated_at'] = now();
            array_push($childLinkedLeague, $tempData);
        }

        ChildLinkedLeague::insert($childLinkedLeague);

        return $parentLinkedLeague;
    }

    public function getChildLinkedLeagues($parentLinkedLeagueId)
    {
        return ChildLinkedLeague::where('parent_linked_league_id', $parentLinkedLeagueId)->pluck('division_id')->toArray();
    }

    public function getParentLinkedLeagueDivision($parentLinkedLeagueId)
    {
        return  ParentLinkedLeague::find($parentLinkedLeagueId)->division_id;
    }

    public function save($division, $data)
    {
        $parentLinkedLeague = ParentLinkedLeague::create([
            'division_id' => $division->id,
            'name' => $data['linkLeagueName'],
        ]);

        $selecedLeagues = $data['childLeagues'];

        $childLinkedLeague = [];
        foreach ($selecedLeagues as $key => $value) {
            $tempData = [];
            $tempData['parent_linked_league_id'] = $parentLinkedLeague->id;
            $tempData['division_id'] = $value;
            $tempData['created_at'] = now();
            $tempData['updated_at'] = now();
            array_push($childLinkedLeague, $tempData);
        }

        ChildLinkedLeague::insert($childLinkedLeague);

        return $parentLinkedLeague;
    }
}
