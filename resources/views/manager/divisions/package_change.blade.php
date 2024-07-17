@extends('layouts.manager')

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/package_change.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li></li>
                <li class="text-center">Select a package</li>
                <li class="text-right"></li>
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
                	<form class="js-package-change-form" action="{{ route('manage.division.package.update', ['division' => $division]) }}" method="post">
                    	{{ csrf_field() }}
	                    <div class="row mt-1 mb-100">
	                        <div class="col-12">
	                            @foreach($packages as $package)
	                                {{-- @if( $seasonAvailablePackages && in_array($package->id, $seasonAvailablePackages)) --}}
			                            <div class="js-select-package cta-block {{ $package->id == $division->package_id ? 'active' : '' }}">
			                            	<input class="d-none" type="radio" name="package_id" value="{{ $package->id }}" {{ $package->id == $division->package_id ? 'checked' : '' }}>
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
                                                    @if($checkNewUserteam)
                                                        @if($divisionUid == 1 && $division->is_legacy == 0)
                                                            @if($package->free_placce_for_new_user == 'Yes')
                                                                <div class="badge">
                                                                    {!!  "FREE <small>PER TEAM</small>" !!}
                                                                </div>
                                                            @else
                                                                <div class="badge">
                                                                    {!! $package->price == 0 ? "FREE" : "£".$package->price . " <small>PER TEAM</small>" !!}
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="badge">
                                                                {!! $package->price == 0 ? "FREE" : "£".$package->price . " <small>PER TEAM</small>" !!}
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="badge">
                                                            {!! $package->price == 0 ? "FREE" : "£".$package->price . " <small>PER TEAM</small>" !!}
                                                        </div>
                                                    @endif
                                                </div>
			                                    @if($package->long_description)
				                                    <div class="cta-link-block">
			                            				<a href="{{route('manager.division.package.details', ['division' => $division, 'package' => $package])}}" data-package-id="{{$package->id}}" class="open_modal_box link-nostyle">
				                                      		<span><i class="fl fl-info"></i></span>
			                            				</a>
				                                    </div>
			                                    @endif
			                                </div>
			                            </div>
		                            {{-- @endif --}}
	                            @endforeach
	                        </div>
	                    </div>
	                    <div class="row mb-3 justify-content-center">
	                        <div class="col-12 col-md-10 col-lg-7">
	                            <button type="submit" class="btn btn-primary btn-block">
	                                Next
	                            </button>
	                        </div>
	                    </div>
                	</form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('modals')
<div class="modal fade" id="modal-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">

</div>
@endpush
