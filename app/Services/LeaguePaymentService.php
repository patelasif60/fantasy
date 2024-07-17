<?php

namespace App\Services;

use App\Repositories\DivisionTeamRepository;
use App\Repositories\LeaguePaymentRepository;

class LeaguePaymentService
{
    /**
     * The LeaguePayment repository instance.
     *
     * @var LeaguePaymentRepository
     */
    protected $leaguePaymentRepository;

    /**
     * The DivisionTeamRepository repository instance.
     *
     * @var DivisionTeamRepository
     */
    protected $divisionTeamRepository;

    /**
     * Create a new service instance.
     *
     * @param LeaguePaymentRepository $leaguePaymentRepository
     */
    public function __construct(LeaguePaymentRepository $leaguePaymentRepository, DivisionTeamRepository $divisionTeamRepository)
    {
        $this->leaguePaymentRepository = $leaguePaymentRepository;
        $this->divisionTeamRepository = $divisionTeamRepository;
    }

    public function getCheckoutData($data, $division, $user)
    {
        return $this->leaguePaymentRepository->getCheckoutData($data, $division, $user);
    }

    public function makePayment($data, $division, $user)
    {
        return $this->leaguePaymentRepository->makePayment($data, $division, $user);
    }

    public function getLeaguePaymentStatus($division, $consumer)
    {
        return $this->leaguePaymentRepository->getLeaguePaymentStatus($division, $consumer);
    }

    public function getLeagueUnpaidTeamsList($division)
    {
        return $this->leaguePaymentRepository->getUnpaidLeagueTeams($division->id)->get()->pluck('team_id')->all();
    }

    public function isLeagueAccessible($division)
    {
        return $this->leaguePaymentRepository->isLeagueAccessible($division);
    }

    public function getUnpaidLeagues()
    {
        return $this->leaguePaymentRepository->getUnpaidLeagues();
    }

    public function getLeaguePaymentMessage($division, $consumer)
    {
        return $this->leaguePaymentRepository->getLeaguePaymentMessage($division, $consumer);
    }

    public function getTeamsSortByUser($data, $division)
    {
        return $this->leaguePaymentRepository->getTeamsSortByUser($data, $division);
    }

    public function checkPaymentForSocialLeague($id, $division)
    {
        return $this->leaguePaymentRepository->checkPaymentForSocialLeague($id, $division);
    }
}
