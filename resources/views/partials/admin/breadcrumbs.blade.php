@if ($breadcrumbs->count())
    <nav class="breadcrumb bg-white push">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$loop->last)
                <a class="breadcrumb-item" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
            @else
                <span class="breadcrumb-item active">{{ $breadcrumb->title }}</span>
            @endif
        @endforeach
    </nav>
@endif
