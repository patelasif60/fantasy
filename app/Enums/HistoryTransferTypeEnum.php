<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class HistoryTransferTypeEnum extends Enum implements LocalizedEnum
{
    const SEALEDBIDS = 'sealedbids';
    const TRANSFER = 'transfer';
    // const TRADE = 'trade';
    const SWAPDEAL = 'swapdeal';
    const SUPERSUB = 'supersub';
    const SUBSTITUTION = 'substitution';
    const BUDGETCORRECTION = 'budgetcorrection';
}
