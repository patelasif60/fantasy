<?php

/**
 * Basic app configuration variables.
 */
return [

	'login' => [
		'isMsgEnabled' => false,
		'logo' => add_slash_in_url_end(config('app.url')).'img/logo.png',
		'registerUrl' => add_slash_in_url_end(config('app.url')).'register',
		'message' => "Login Message"
	],

	'register' => [
		'createLeague' => 'Create a League',
		'createLeagueMessage' => "Click here to set up your own league.",
		'createUrl' => add_slash_in_url_end(config('app.url')).'manage/division/create',
		'createImg' => add_slash_in_url_end(config('app.url')).'assets/frontend/img/cup/cup1-thumb.png',
		'joinALeague' => 'Join a League',
		'joinALeagueMessage' => "Click here to join an existing Private or Social league.",
		'joinALeagueUrl' => add_slash_in_url_end(config('app.url')).'manage/division/join/league/select',
		'joinALeagueImg' => add_slash_in_url_end(config('app.url')).'assets/frontend/img/cup/cup2-thumb.png',
		'arrow' => add_slash_in_url_end(config('app.url')).'assets/frontend/img/arrow/arrow.png',
	],

	'supersubs' => [
		'isSuperSubPopupShow' => env('IS_SHOW_SUPERSUB_POPUP', true),
		'title' => 'Supersubs Guide',
		'message' => 'Click on a fixture time above the pitch to see players active in matches at that fixture time highlighted in green. Where possible, your active players are automatically placed into your team but need to be saved for each fixture time. You can make changes by clicking on relevant player(s) and to accept changes hit ACCEPT AND SAVE. To cancel changes for that block of fixtures hit CANCEL.',
        'message1' => 'The dates where you have an unsaved line-up are highlighted in orange, whilst the dates where your line-up is saved are highlighted in white.',
        'message2' => 'The ticks / crosses shown on the last column of the right-hand list view show whether a player has been selected against the listed match. Hit refresh to make sure this shows the latest information.',
	],

	'version' => [
		'android' => env('ANDROID_VERSION', '0.0.0'),
		'ios' => env('IOS_VERSION', '0.0.0'),
	],

	'feature_disabled' => [
		'isSiteDown' => false,
		'isTransferDown' => false,
		'isTransferSealedbidDown' => false,
		'isSwapsDown' => false,
		'isAuctionOfflineDown' => false,
		'isAuctionSealedbidDown' => false,
		'isSupersubDown' => false,
	],
];
