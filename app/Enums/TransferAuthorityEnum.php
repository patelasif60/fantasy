<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class TransferAuthorityEnum extends Enum implements LocalizedEnum
{
    const CHAIRMAN = 'chairman';
    const CHAIRMAN_AND_COCHAIRMAN = 'chairmanandcochairman';
    const ALL = 'all';
}
