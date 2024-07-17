@if ($breadcrumbs->count())
    <div class="content">
        <nav class="breadcrumb mb-0">
            @foreach ($breadcrumbs as $breadcrumb)
                @if (!$loop->last)
                    <a class="breadcrumb-item" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                @else
                    <span class="breadcrumb-item active">{{ $breadcrumb->title }}</span>
                @endif
            @endforeach
        </nav>
    </div>
@endif
