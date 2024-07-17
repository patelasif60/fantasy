@extends('layouts.manager')

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/feed/details.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li class="text-left">
                	<a href="{{url()->previous()}}?from=news_details"><span>
                        <i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back
                    </a>
                </li>
                <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                <li>
                    {{-- <a href="@if(isset($division) && $division) {{ route('manage.more.division.index', ['division' => $division ]) }} @else {{ route('manage.more.index') }} @endif">
                        <span><i class="fas fa-bars"></i></span>
                    </a> --}}
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fl fl-bar"></span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="row align-items-center justify-content-center">
    <div class="col-12 text-white">
    	<div class="blog-post">
            <div class="blog-area" id="news_details"></div>
        </div>
	</div>
</div>
@endsection
