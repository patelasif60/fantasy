<?php

namespace App\Services;

use App\Enums\PlayerContractPosition\AllPositionEnum;

class ValidateTransferFormationService
{
    public function checkPossibleFormation($availableFormations, $mergeDefenders, $players)
    {
        $allowedFormations = $this->getFormattedAllowedFormations($availableFormations, $mergeDefenders);
        $players = $this->getTeamPositionsCount($players, $mergeDefenders);

        foreach ($allowedFormations as $key => $formation) {
            if ($mergeDefenders == 'Yes') {
                if ($players[AllPositionEnum::GOALKEEPER] >= $formation[AllPositionEnum::GOALKEEPER]
                &&
                $players[AllPositionEnum::STRIKER] >= $formation[AllPositionEnum::STRIKER] &&
                $players[AllPositionEnum::MIDFIELDER] >= $formation[AllPositionEnum::MIDFIELDER] &&
                $players[AllPositionEnum::DEFENDER] >= $formation[AllPositionEnum::DEFENDER]
                ) {
                    return true;
                }
            } else {
                if ($players[AllPositionEnum::GOALKEEPER] >= $formation[AllPositionEnum::GOALKEEPER]
                &&
                $players[AllPositionEnum::STRIKER] >= $formation[AllPositionEnum::STRIKER] &&
                $players[AllPositionEnum::MIDFIELDER] >= $formation[AllPositionEnum::MIDFIELDER] &&
                $players[AllPositionEnum::CENTREBACK] >= $formation[AllPositionEnum::CENTREBACK]
                &&
                $players[AllPositionEnum::FULLBACK] >= $formation[AllPositionEnum::FULLBACK]
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function getFormattedAllowedFormations($availableFormations, $mergeDefenders)
    {
        return $this->allowedFormations($availableFormations, $mergeDefenders)->map(function ($item) use ($mergeDefenders) {
            $keys = collect(explode('-', $item))->map(function ($item, $key) {
                return (int) $item;
            });

            return $this->positions($mergeDefenders)->combine($keys)->all();
        });
    }

    protected function allowedFormations($availableFormations, $mergeDefenders)
    {
        $availableFormations = collect($availableFormations);

        if ($mergeDefenders == 'Yes') {
            $formations = collect(['442' => '1-4-4-2', '451' => '1-4-5-1', '433' => '1-4-3-3', '532' => '1-5-3-2', '541' => '1-5-4-1']);
        } else {
            $formations = collect(['442' => '1-2-2-4-2', '451' => '1-2-2-5-1', '433' => '1-2-2-3-3', '532' => '1-2-3-3-2', '541' => '1-2-3-4-1']);
        }

        return $formations = $formations->filter(function ($item, $key) use ($availableFormations) {
            if ($availableFormations->contains($key)) {
                return $item;
            }
        });
    }

    protected function positions($mergeDefenders)
    {
        if ($mergeDefenders == 'Yes') {
            return collect([AllPositionEnum::GOALKEEPER, AllPositionEnum::DEFENDER, AllPositionEnum::MIDFIELDER, AllPositionEnum::STRIKER]);
        }

        return collect([AllPositionEnum::GOALKEEPER, AllPositionEnum::FULLBACK, AllPositionEnum::CENTREBACK, AllPositionEnum::MIDFIELDER, AllPositionEnum::STRIKER]);
    }

    protected function getTeamPositionsCount($teamPositionsCount, $mergeDefenders)
    {
        if (! array_has($teamPositionsCount, AllPositionEnum::GOALKEEPER)) {
            $teamPositionsCount[AllPositionEnum::GOALKEEPER] = 0;
        }

        if (! array_has($teamPositionsCount, AllPositionEnum::STRIKER)) {
            $teamPositionsCount[AllPositionEnum::STRIKER] = 0;
        }

        if (! array_has($teamPositionsCount, AllPositionEnum::MIDFIELDER)) {
            $total = 0;

            if (array_has($teamPositionsCount, AllPositionEnum::DEFENSIVE_MIDFIELDER)) {
                $total = $total + $teamPositionsCount[AllPositionEnum::DEFENSIVE_MIDFIELDER];
                unset($teamPositionsCount[AllPositionEnum::DEFENSIVE_MIDFIELDER]);
            }

            $teamPositionsCount[AllPositionEnum::MIDFIELDER] = $total;
        } else {
            $total = $teamPositionsCount[AllPositionEnum::MIDFIELDER];

            if (array_has($teamPositionsCount, AllPositionEnum::DEFENSIVE_MIDFIELDER)) {
                $total = $total + $teamPositionsCount[AllPositionEnum::DEFENSIVE_MIDFIELDER];
                unset($teamPositionsCount[AllPositionEnum::DEFENSIVE_MIDFIELDER]);
            }

            $teamPositionsCount[AllPositionEnum::MIDFIELDER] = $total;
        }

        if ($mergeDefenders == 'Yes') {
            $total = 0;
            if (array_has($teamPositionsCount, AllPositionEnum::FULLBACK)) {
                $total = $total + $teamPositionsCount[AllPositionEnum::FULLBACK];
            }
            if (array_has($teamPositionsCount, AllPositionEnum::CENTREBACK)) {
                $total = $total + $teamPositionsCount[AllPositionEnum::CENTREBACK];
            }

            unset($teamPositionsCount[AllPositionEnum::FULLBACK]);
            unset($teamPositionsCount[AllPositionEnum::CENTREBACK]);
            $teamPositionsCount[AllPositionEnum::DEFENDER] = $total;
        } else {
            if (! array_has($teamPositionsCount, AllPositionEnum::FULLBACK)) {
                $teamPositionsCount[AllPositionEnum::FULLBACK] = 0;
            }

            if (! array_has($teamPositionsCount, AllPositionEnum::CENTREBACK)) {
                $teamPositionsCount[AllPositionEnum::CENTREBACK] = 0;
            }
        }

        return $teamPositionsCount;
    }
}
