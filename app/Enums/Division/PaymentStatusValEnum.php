<?php

namespace App\Enums\Division;

use BenSampo\Enum\Enum;

final class PaymentStatusValEnum extends Enum
{
    const PAID = 'PAID';
    const PENDING = 'PENDING';
    const OTHER = 'OTHER';
}
