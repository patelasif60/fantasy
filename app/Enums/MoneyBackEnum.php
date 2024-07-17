<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class MoneyBackEnum extends Enum implements LocalizedEnum
{
    const NONE = 'none';
    const HUNDERED_PERCENT = 'hunderedPercent';
    const FIFTY_PERCENT = 'fiftyPercent';
    const CHAIRMAN_CAN_EDIT_BOUGHT_AND_SOLDPRICE = 'chairmaneditboughtsoldprice';
}
