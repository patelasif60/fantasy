<?php

return [
    'data' => [
        'saved' => [
            'success' => 'Details have been saved successfully.',
            'error' => 'Details could not be saved at this time. Please try again later.',
        ],
        'updated' => [
            'success' => 'Details have been updated successfully.',
            'error' => 'Details could not be updated at this time. Please try again later.',
        ],
        'deleted' => [
            'success' => 'Data have been deleted successfully.',
            'error' => 'Data could not be deleted at this time. Please try again later.',
        ],
        'reset' => [
            'success' => 'Data have been reset successfully.',
            'error' => 'Data could not be reset at this time. Please try again later.',
        ],
        'account' => [
            'success' => 'Your Account Information has been updated.',
            'error' => 'Your Account information could not be updated. Please try again later.',
        ],
    ],
    'server_validation'=>[
        'date_overlap'=>':messageobject already exists at this :datefieldname .. Select another date',
    ],
    'divisions' => [
        'league_create' => 'Fantasy League New Chairman Guide',
        'join_a_league' => 'League invitation',
        'invitation_sent' => 'League invitation sent successfully',
        'joined_league' => 'Fantasy League New Applicant',
        'already_joined' => 'You have already joined this league',
        'code_not_available' => 'Invite code for ":division" league not available',
        'league_approval' => 'League Approval',
        'league_ignore' => 'League Application Rejected',
        'league_join' => 'Fantasy League Join League Request',
        'auction_close' => 'Auction closed',
        'auction_process' => 'Please wait we are processing your bids.',
        'team_create' => 'Fantasy League Team Confirmation',
        'social_league_join' => 'Social League',
        'league_payment_receipt'=>'Fantasy League Payment Confirmation',
        'max_team' => 'This league already has the maximum number of teams permitted. If you have been invited to join the league, an existing member will need to remove their team first to enable you to join - please contact your chairman.',
        'league_Payment_other' => 'Fantasy League Team Payment',
    ],
    'online_sealed_bid'=>[
        'round_email'=> 'Your league auction round is a start now.',
        'auction_completed'=> 'Fantasy League Sealed Bids Auction – Completed',
        'deadline_approaching'=> 'Fantasy League Sealed Bids Auction – Deadline Approaching.',
        'round_process'=> 'Fantasy League Sealed Bids Auction – Round Processed',
        'auction_round_deadline_changed'=> 'Fantasy League Sealed Bids Auction – Deadline Changed',
        'auction_created'=> 'Fantasy League Sealed Bids Auction – Now Live',
        'auction_bids_placed'=> 'Fantasy League Sealed Bids Auction – Deadline Changed',
        'click_against_icon'=> 'To enter bids click the icon against any position',
    ],
    'offline_auction'=>[
        'click_against_icon'=>'To enter bids click the icon against any position',
    ],
    'auth'=>[
        'register_email'=>'Welcome to Fantasy League!',
        'reset_password'=>'Fantasy League Password Change Confirmation',
        'change_email_address'=>'Fantasy League Email Change Confirmation',
    ],
    'permission'=> [
        'permissionMessage' => 'Permission Disabled! Please update in your phone settings and try again.'
    ],
    'swap' => [
        'saved' => [
            'success' => 'Swaps were successfully processed. Please note that pending Supersubs have been cancelled.',
            'error' => 'Swaps were not successfully processed. Please try again later.',
        ],
        'formation' => [
            'error' => 'Invalid Formation. Swaps were not successfully processed.',
        ],
        'team_budget' => [
            'error' => 'Team budget is not enough. Swaps were not successfully processed.',
        ],
        'club_quota' => [
            'error' => 'Club quota is full. Swaps were not successfully processed.',
        ],
    ],
    'online_sealed_bid_transfer'=> [
        'round_end'=>'Sealed Bids Transfer',
        'round_created'=>'New Sealed Bid Round',
        'round_deadline_changed'=>'Sealed Bid Round Deadline Change',
        'round_completed'=>'Sealed Bids Round Complete',
    ],
    'auction' => [
        'message' => 'You can change the dates of a round any time before it has started. Typically, five rounds are required to complete an auction.',
        'message1' => 'If future rounds are not scheduled, they will be added automatically with a 24 hour duration.',
        'message2' => 'To save changes to your round schedule, close this window and hit UPDATE on the Auction Settings page.',
    ],
    'transfer_settings' => [
        'message' => 'To save changes to your round schedule, close this window and hit UPDATE on the Transfers and sealed bids settings page.',
    ],
    'leagues_messages' => [
        'no_league_found' => 'There is no league found.',
        'request_join_pending' => 'Your request to join the league is pending approval by league chairman.',
    ],
    'transfer' => [
        'saved' => [
            'success' => 'Transfer were successfully processed. Please note that pending Supersubs have been cancelled.',
            'error' => 'Transfer were not successfully processed. Please try again later.',
        ],
        'formation' => [
            'error' => 'You have an invalid formation. Transfers have not been saved.',
            'success' => 'valid Formation.',
        ],
        'club_quota' => [
            'error' => 'You have exceeded the maximum number of players per club. Transfers have not been saved.',
        ],
        'squad_size' => [
            'error' => 'Not enough players. Transfers have not been saved.',
        ],
        'seasons_quota' => [
            'error' => 'Season quota is not available. Transfer were not successfully processed.',
        ],
        'monthly_quota' => [
            'error' => 'Monthly quota is not available. Transfer were not successfully processed.',
        ],
        'already_in_team' => [
            'error' => 'Transfer player already in other team. Transfers have not been saved.',
        ],
        'line_up' => [
            'error' => 'NOT DONE - Please refresh for current line-up.',
        ],
        'budget' => [
            'error' => 'Team budget is not enough. Transfers were not successfully processed.',
        ],
        'budget_exceeded' => [
            'error' => 'You have exceeded your budget. Transfers have not been saved.',
        ],
        'supersubs_canceled' => [
            'error' => 'If you complete this process, team supersubs will be cancelled',
        ],
    ],
    'contact_us' => [
        'subject' => 'New Contact',
        'success_message' => 'Thank you for your message. Our customer support team will contact you within the next working day.',
        'error_message' => 'Could not submit. Please try again later.',
    ],
];
