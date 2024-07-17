<div class="chat {{ $messageClass }} js-chat-block">
	<div class="messege-container">
		@can('ownLeagues', $division) <div data-id="{{ $id }}" class="js-delete-message" title="Delete message"><i class="fas fa-trash" aria-hidden="true"></i></div> @endcan
		<div class="messege">
			<div class="profile-name">{{ $first_name }} {{ $last_name }}</div>
			<div class="profile-msg">{{ $message }}</div>
		</div>
		<div class="messege-info">{{ get_date_time_in_carbon($time)->format(config('fantasy.messagetime.format')) }}</div>
	</div>
</div>