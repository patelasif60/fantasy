<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class ManuallyProcessStatusEnum extends Enum implements LocalizedEnum
{
    const PENDING = 'pending';
    const PROCESSED = 'processed';
    const COMPLETED = 'completed';
}
