@extends('layouts.manager-league-settings')

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/package_change.js') }}"></script>
@endpush

@section('page-name')
Select Your Package
@endsection

@section('right')
	<form class="js-package-change-form" action="{{ route('manage.division.settings.edit',['division' => $division, 'name' => 'package' ]) }}" method="post">
    	{{ csrf_field() }}
        <div class="row mt-1 mb-5">
            <div class="col-12">
                @foreach($packages as $package)
                    @if( $seasonAvailablePackages && in_array($package->id, $seasonAvailablePackages))
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
                    @endif
                @endforeach
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-8 col-md-6 col-lg-4">
                <button type="submit" class="btn btn-primary btn-block">
                    Next
                </button>
            </div>
        </div>
	</form>
@endsection

@push('modals')
<div class="modal fade" id="modal-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">

</div>
@endpush
