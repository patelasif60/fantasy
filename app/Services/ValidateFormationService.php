<?php

namespace App\Services;

use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Models\Division;

class ValidateFormationService
{
    public function getEnabledPositions(Division $division, $teamPositionsCount)
    {
        $positionEnabled = [];
        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        $availableFormations = $division->getOptionValue('available_formations');

        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $teamPositionsCount = $this->getTeamPositionsCount($teamPositionsCount, $mergeDefenders);

        $allowedFormations = $this->getFormattedAllowedFormations($availableFormations, $mergeDefenders);

        foreach ($teamPositionsCount as $position => $count) {
            if ($count < $this->absoluteMinimumForPosition($position, $allowedFormations)) {
                array_push($positionEnabled, $position);
            } elseif ($this->shouldPositionBeEnabled($teamPositionsCount, $position, $defaultSquadSize, $allowedFormations)) {
                array_push($positionEnabled, $position);
            }
        }

        return $positionEnabled;
    }

    protected function shouldPositionBeEnabled($teamPositionsCount, $position, $defaultSquadSize, $allowedFormations)
    {
        // For each of the available formations, calculate the sum of the number of the remaining positions still required.
        $allCounts = [];
        foreach ($allowedFormations as $formation) {
            foreach (array_except($formation, $position) as $pos => $count) {
                // compare user's team count with the formation count and if user's count is less, consider it in the array.
                $usersCount = $teamPositionsCount[$pos];
                if ($usersCount < $count) {
                    $allCounts[$pos][] = $count - $usersCount;
                } else {
                    $allCounts[$pos][] = 0;
                }
            }
        }

        $pendingPositionsForEachFormation = [];

        for ($i = 0; $i < count($allowedFormations); $i++) {
            $pendingPositionsForEachFormation[] = array_sum(array_column($allCounts, $i));
        }

        // Get the squad size and subtract the minimum number of players pending selection.
        return min($pendingPositionsForEachFormation) < ($defaultSquadSize - array_sum($teamPositionsCount));
    }

    protected function absoluteMinimumForPosition($position, $allowedFormations)
    {
        return (int) collect($allowedFormations)->pluck($position)->min();
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
