<?php

namespace App\Services;

use App\Repositories\LinkedLeagueRepository;
use Session;

class LinkedLeagueService
{
    /**
     * The LinkedLeague repository instance.
     *
     * @var LinkedLeagueRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param LinkedLeagueRepository $repository
     */
    public function __construct(LinkedLeagueRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getLinkedLeagues($division)
    {
        return $this->repository->getLinkedLeagues($division);
    }

    public function getSearchLeagueResults($division, $data, $selecedLeagues = null)
    {
        if (! $selecedLeagues) {
            $selecedLeagues = [];
        }

        if (Session::has('linkedLeague')) {
            $linkedLeague = session('linkedLeague');
            $selecedLeagues = $linkedLeague[$division->id];
        }

        return $this->repository->getSearchLeagueResults($division, $data, $selecedLeagues);
    }

    public function storeSelectedLeague($division, $league)
    {
        if (Session::has('linkedLeague')) {
            $linkedLeague = session('linkedLeague');
        }

        $linkedLeague[$division->id][] = $league;
        Session::put('linkedLeague', $linkedLeague);
    }

    public function getLeagueData($division, $selectedLeagues)
    {
        return $this->repository->getLeagueData($selectedLeagues);
    }

    public function store($division, $data)
    {
        return $this->repository->store($division, $data);
    }

    public function saveSelectedLeague($division, $data)
    {
        Session::forget('linkedLeague');
        $linkedLeague[$division->id] = $data['leagueId'];
        Session::put('linkedLeague', $linkedLeague);
    }

    public function save($division, $data)
    {
        return $this->repository->save($division, $data);
    }
}
