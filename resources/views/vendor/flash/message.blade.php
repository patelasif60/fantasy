@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="custom-alert alert
                    alert-{{ $message['level'] }}
                    {{ $message['important'] ? 'alert-important' : '' }}"
                    role="alert"
        >
            {{-- <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-hidden="true"
            ><i class="fal fa-xs fa-times-circle"></i></button> --}}

            @if(strtolower($message['level']) === 'success')
                <i class="fas fal fa-check-circle mr-2"></i>
            @elseif(strtolower($message['level']) === 'danger')
                <i class="fas fal fa-exclamation-circle mr-2"></i>
            @elseif(strtolower($message['level']) === 'warning')
                <i class="fas fal fa-exclamation-triangle mr-2"></i>
            @endif
            <div class="alert-text">
                {!! $message['message'] !!}
            </div>
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
