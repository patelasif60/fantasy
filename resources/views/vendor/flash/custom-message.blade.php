@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        @if(strtolower($message['level']) === 'success')
         <div class="js-custom-flash">
             <div class="custom-alert alert-tertiary js-custom-flash">
                <div class="alert-text">
                     {!! $message['message'] !!}
                </div>
            </div>
        </div>
        @elseif(strtolower($message['level']) === 'danger')
        <div class="js-custom-flash">
            <div class="custom-alert alert-danger ">
                <div class="alert-text">
                   {!! $message['message'] !!}
                </div>
            </div>
        </div>
        @elseif(strtolower($message['level']) === 'warning')
        @endif
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
