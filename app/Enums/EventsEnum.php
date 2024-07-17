<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class EventsEnum extends Enum implements LocalizedEnum
{
    const GOAL = 'goal';
    const ASSIST = 'assist';
    const GOAL_CONCEDED = 'goal_conceded';
    const CLEAN_SHEET = 'clean_sheet';
    const APPEARANCE = 'appearance';
    const CLUB_WIN = 'club_win';
    const RED_CARD = 'red_card';
    const YELLOW_CARD = 'yellow_card';
    const OWN_GOAL = 'own_goal';
    const PENALTY_MISSED = 'penalty_missed';
    const PENALTY_SAVE = 'penalty_save';
    const GOALKEEPER_SAVE_X5 = 'goalkeeper_save_x5';
}
