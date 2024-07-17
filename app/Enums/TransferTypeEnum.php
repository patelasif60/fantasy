<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class TransferTypeEnum extends Enum implements LocalizedEnum
{
    const SEALEDBIDS = 'sealedbids';
    const TRANSFER = 'transfer';
    const TRADE = 'trade';
    const AUCTION = 'auction';
    const SUBSTITUTION = 'substitution';
    const BUDGETCORRECTION = 'budgetcorrection';
    const SUPERSUB = 'supersub';
    const SWAPDEAL = 'swapdeal';
}
