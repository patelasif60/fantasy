<?php

use App\Enums\AgentTransferAfterEnum;
use App\Enums\AuctionTypesEnum;
use App\Enums\Division\AuctionTypeEnum;
use App\Enums\Division\StatusEnum;
use App\Enums\Division\TransferStartEnum;
use App\Enums\Division\YesNoEnum;
use App\Enums\EventsEnum;
use App\Enums\FixtureEventHalfEnum;
use App\Enums\FormationEnum;
use App\Enums\HistoryTransferTypeEnum;
use App\Enums\MoneyBackEnum;
use App\Enums\PointAdjustmentsEnum;
use App\Enums\PositionsEnum;
use App\Enums\Role\AdminEnum;
use App\Enums\Role\ConsumerEnum;
use App\Enums\Role\RoleEnum;
use App\Enums\SealedBidDeadLinesEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\TransferAuthorityEnum;
use App\Enums\TransferTypeEnum;
use App\Enums\UserStatusEnum;

return [
    UserStatusEnum::class => [
        UserStatusEnum::ACTIVE => 'Active',
        UserStatusEnum::SUSPENDED => 'Suspended',
    ],
    AdminEnum::class => [
        AdminEnum::SUPERADMIN => 'Admin',
        AdminEnum::STAFF => 'Customer service',
    ],
    ConsumerEnum::class => [
        ConsumerEnum::USER => 'Consumer',
    ],
    RoleEnum::class => [
        RoleEnum::SUPERADMIN => 'Admin',
        RoleEnum::STAFF => 'Customer service',
        RoleEnum::USER => 'Consumer',
    ],
    TransferTypeEnum::class => [
        TransferTypeEnum::SEALEDBIDS => 'Sealed bid',
        TransferTypeEnum::TRANSFER => 'Transfer',
        TransferTypeEnum::TRADE => 'Trade',
        TransferTypeEnum::AUCTION => 'Auction',
        TransferTypeEnum::SUBSTITUTION => 'Substitution',
        TransferTypeEnum::BUDGETCORRECTION => 'Budget correction',
        TransferTypeEnum::SUPERSUB => 'Supersub',
        TransferTypeEnum::SWAPDEAL => 'Swap deal',
    ],
    AuctionTypeEnum::class => [
        AuctionTypeEnum::SEALEDBIDSAUCTION => 'Sealed Bids Auction',
        AuctionTypeEnum::REALTIMEAUCTION => 'Real Time Auction',
        AuctionTypeEnum::MANUALENTRY => 'Manual Entry',
    ],
    StatusEnum::class => [
        StatusEnum::ALLPAID => 'All Paid',
        StatusEnum::NOTPAID => 'Not Paid',
    ],
    FormationEnum::class => [
        FormationEnum::_442 => '4-4-2',
        FormationEnum::_451 => '4-5-1',
        FormationEnum::_433 => '4-3-3',
        FormationEnum::_532 => '5-3-2',
        FormationEnum::_541 => '5-4-1',
    ],
    YesNoEnum::class => [
        YesNoEnum::YES => 'Yes',
        YesNoEnum::NO => 'No',
    ],
    TransferAuthorityEnum::class => [
        TransferAuthorityEnum::CHAIRMAN => 'Chairman',
        TransferAuthorityEnum::CHAIRMAN_AND_COCHAIRMAN => 'Chairman and Co-chairman',
        TransferAuthorityEnum::ALL => 'All',
    ],
    TransferStartEnum::class => [
        TransferStartEnum::SESSIONSTART => 'Session Start',
        TransferStartEnum::SESSIONEND => 'Session End',
    ],
    PointAdjustmentsEnum::class => [
        PointAdjustmentsEnum::REGULAR_SEASON => 'Regular season',
        PointAdjustmentsEnum::FA_CUP => 'FA Cup',
    ],
    SealedBidDeadLinesEnum::class => [
        SealedBidDeadLinesEnum::DONTREPEAT => 'Don’t repeat',
        SealedBidDeadLinesEnum::EVERYMONTH => 'Every month',
        SealedBidDeadLinesEnum::EVERYFORTNIGHT => 'Every fortnight',
        SealedBidDeadLinesEnum::EVERYWEEK => 'Every week',
    ],
    MoneyBackEnum::class => [
        MoneyBackEnum::NONE => 'None',
        MoneyBackEnum::HUNDERED_PERCENT => 'Full bought price',
        MoneyBackEnum::FIFTY_PERCENT => 'Half of bought price',
        MoneyBackEnum::CHAIRMAN_CAN_EDIT_BOUGHT_AND_SOLDPRICE => 'Chairman can edit bought and sold price',
    ],
    TiePreferenceEnum::class => [
        TiePreferenceEnum::NO => 'No tie preference',
        TiePreferenceEnum::EARLIEST_BID_WINS => 'Earliest bid wins',
        TiePreferenceEnum::LOWER_LEAGUE_POSITION_WINS => 'Lower league position wins',
        TiePreferenceEnum::HIGHER_LEAGUE_POSITION_WINS => 'Higher league position wins',
        TiePreferenceEnum::RANDOMLY_ALLOCATED => 'Randomly allocated',
        TiePreferenceEnum::RANDOMLY_ALLOCATED_REVERSES => 'Randomly allocated, then reverses each round',
    ],
    AgentTransferAfterEnum::class => [
        AgentTransferAfterEnum::AUCTIONEND => 'Auction end',
        AgentTransferAfterEnum::SEASONSTART => 'Season start',
    ],
    PositionsEnum::class => [
        PositionsEnum::GOAL_KEEPER => 'GK',
        PositionsEnum::CENTER_BACK => 'CB',
        PositionsEnum::FULL_BACK => 'FB',
        PositionsEnum::DEFENSIVE_MIDFIELDER => 'DMF',
        PositionsEnum::MIDFIELDER => 'MF',
        PositionsEnum::STRIKER => 'ST',
    ],
    EventsEnum::class => [
        EventsEnum::GOAL => 'Goal',
        EventsEnum::ASSIST => 'Assist',
        EventsEnum::GOAL_CONCEDED => 'Goal conceded',
        EventsEnum::CLEAN_SHEET => 'Clean sheet',
        EventsEnum::APPEARANCE => 'Appearance',
        EventsEnum::CLUB_WIN => 'Club win',
        EventsEnum::RED_CARD => 'Red card',
        EventsEnum::YELLOW_CARD => 'Yellow card',
        EventsEnum::OWN_GOAL => 'Own goal',
        EventsEnum::PENALTY_MISSED => 'Penalty missed',
        EventsEnum::PENALTY_SAVE => 'Penalty save',
        EventsEnum::GOALKEEPER_SAVE_X5 => 'Goalkeeper save x5',
    ],
    AuctionTypesEnum::class => [
        AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION => 'Online sealed bids auction',
        AuctionTypesEnum::LIVE_ONLINE_AUCTION => 'Live online auction',
        AuctionTypesEnum::OFFLINE_AUCTION => 'Live offline auction',
    ],
    FixtureEventHalfEnum::class => [
        FixtureEventHalfEnum::FIRST_HALF => 'First half',
        FixtureEventHalfEnum::SECOND_HALF => 'Second half',
        FixtureEventHalfEnum::EXTRA_TIME_FIRST_HALF => 'Extra time (first half)',
        FixtureEventHalfEnum::EXTRA_TIME_SECOND_HALF => 'Extra time (second half)',
    ],
    HistoryTransferTypeEnum::class => [
        HistoryTransferTypeEnum::SEALEDBIDS => 'Transfer (Sealed Bid)',
        HistoryTransferTypeEnum::TRANSFER => 'Transfer',
        // HistoryTransferTypeEnum::TRADE => 'Extra time (first half)',
        HistoryTransferTypeEnum::SWAPDEAL => 'Swap Deal',
        HistoryTransferTypeEnum::SUPERSUB => 'Supersub',
        HistoryTransferTypeEnum::SUBSTITUTION => 'Substitution',
        HistoryTransferTypeEnum::BUDGETCORRECTION => 'Budget Correction',
    ],
];
