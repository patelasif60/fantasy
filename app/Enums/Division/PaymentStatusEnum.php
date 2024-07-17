<?php

namespace App\Enums\Division;

use BenSampo\Enum\Enum;

final class PaymentStatusEnum extends Enum
{
    const PAID = '';
    const OTHER = 'Some teams in your league are pending payment.';
    const PENDING = 'Your team and others in your league are pending payment.';
    const STATUS_CHAIRMAN = 'There are teams in your league that are pending payment.';
}
