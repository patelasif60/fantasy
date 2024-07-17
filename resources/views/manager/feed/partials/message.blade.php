@foreach($messages as $key => $message)
    @if($key == now()->format(config('fantasy.db.date.format')))
        <div class="chat-date">Today</div>
    @elseif($key == now()->subDay(1)->format(config('fantasy.db.date.format')))
        <div class="chat-date">Yesterday</div>
    @else
        <div class="chat-date">{{ carbon_format_to_date($key) }}</div>
    @endif
    @foreach($message as $val)
        @if($val->sender_id == $consumer)
            <div class="chat message-sender js-chat-block">
                <div class="messege-container">
                    @can('ownLeagues',$division) <div data-id="{{ $val->id }}" class="js-delete-message" title="Delete message"><i class="fas fa-trash" aria-hidden="true"></i></div> @endcan
                    <div class="messege">
                        <div class="profile-name">
                            {{$val->first_name.' '.$val->last_name}}
                        </div>
                        <div class="profile-msg">{{ $val->message }}</div>
                    </div>
                    <div class="messege-info">{{ get_date_time_in_carbon($val->created_at)->format(config('fantasy.messagetime.format')) }}</div>
                </div>
            </div>
        @elseif($val->sender_id == 'System')
            <div class="chat message-system js-chat-block">
                <div class="messege-container">
                    @can('ownLeagues',$division) <div data-id="{{ $val->id }}" class="js-delete-message" title="Delete message"><i class="fas fa-trash" aria-hidden="true"></i></div> @endcan
                    <div class="messege">
                        <div class="profile-name">
                            System
                        </div>
                        <div class="profile-msg">{{ $val->message }}</div>
                    </div>
                    <div class="messege-info">{{ get_date_time_in_carbon($val->created_at)->format(config('fantasy.messagetime.format')) }}</div>
                </div>
            </div>
        @else
            <div class="chat message-reciever js-chat-block">
                <div class="messege-container">
                    @can('ownLeagues',$division) <div data-id="{{ $val->id }}" class="js-delete-message" title="Delete message"><i class="fas fa-trash" aria-hidden="true"></i></div> @endcan
                    <div class="messege">
                        <div class="profile-name">
                            {{$val->first_name.' '.$val->last_name}}
                        </div>
                        <div class="profile-msg">{{ $val->message }}</div>
                    </div>
                    <div class="messege-info">{{ get_date_time_in_carbon($val->created_at)->format(config('fantasy.messagetime.format')) }}</div>
                </div>
            </div>
        @endif
    @endforeach
@endforeach
<input type="hidden" class="nextPageUrl" value="{{ $nextPageUrl }}">
