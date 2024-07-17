@extends('layouts.manager')

@push('plugin-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
@endpush

@push('page-scripts')
<script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/manager/global.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manager/divisions/create.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ route('manage.division.index') }}">
                        <span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;League
                    </a>
                </li>
                <li class="text-center">Join League</li>
                <li class="text-right">
                    @include('partials.manager.more_menu')
                </li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <div class="container-wrapper">
                <div class="container-body div-continer">
                    <div class="row mt-1 mb-100">
                        <div class="col-12">
                            @foreach($packages as $package)
                                @if( $seasonAvailablePackages && in_array($package->id, $seasonAvailablePackages))
                                    <a href="{{route('manager.division.package.description', ['package' => $package])}}" data-package-id="{{$package->id}}" class="open_modal_box link-nostyle">
                                    <div class="cta-block">
                                        <div class="league-image">
                                            {{-- <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/cta/badge-' . $package->badgeColor() . '-thumb.png')}}" data-src="{{ asset('assets/frontend/img/cta/badge-' . $package->badgeColor() . '.png')}}" data-srcset="{{ asset('assets/frontend/img/cta/badge-' . $package->badgeColor() . '.png')}} 1x, {{ asset('assets/frontend/img/cta/badge-' . $package->badgeColor() . '@2x.png')}} 2x" alt=""> --}}
                                            <span class="{{ $package->badgeColor() }}"><i class="fl fl-badge"></i></span>
                                        </div>
                                        <div class="cta-wrapper text-center">
                                            <p class="cta-title text-uppercase">{{$package->display_name}}</p>
                                            <div>
                                                <p class="cta-text">{{$package->short_description}}</p>
                                            </div>
                                        </div>
                                        <div class="cta-wrapper text-center">

                                            <div class="cta-link-block">
                                                <div class="badge">{!! $package->price == 0 ? "FREE" : "£".$package->price . " <small>PER TEAM</small>" !!}</div>
                                            </div>
                                            <div class="cta-link-block">
                                                <span><i class="fl fl-info"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-white text-center">
                            <p class="mb-3 f-14">Want to play with like-minded managers?<br> Create or join a
                                {{-- {{route('manager.division.package.description', ['package' => $social_league])}} --}}
                            <a href="#" class="text-white open_modal_box">social league</a> </p>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-12 col-md-10 col-lg-7">
                            <a href="{{route('manage.division.join.new.league')}}" class="btn btn-outline-white btn-block">
                                Join a League
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('modals')
<div class="modal fade" id="modal-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">

</div>
@endpush
