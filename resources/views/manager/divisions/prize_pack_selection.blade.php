@extends('layouts.manager')

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/prize_pack_selection.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li></li>
                <li class="text-center">Prize packs</li>
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
                	<form class="js-select-prize-pack-form" action="{{ route('manage.division.prizepack.update', ['division' => $division]) }}" method="post">
                    	{{ csrf_field() }}
	                    <div class="row mt-1 mb-100">
	                        <div class="col-12">
	                            @foreach($prizePacks as $prizePack)

			                            <div class="js-select-prize-pack cta-block {{ $defaultPackagePrizePack == $prizePack->id ? 'active' : '' }}">
											<input class="d-none" type="radio" name="prize_pack_id" value="{{ $prizePack->id }}" {{ $defaultPackagePrizePack == $prizePack->id ? 'checked' : '' }}>
			                                <div class="league-image">
			                                    {{-- <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/cta/badge-' . $prizePack->badgeColor() . '-thumb.png')}}" data-src="{{ asset('assets/frontend/img/cta/badge-' . $prizePack->badgeColor() . '.png')}}" data-srcset="{{ asset('assets/frontend/img/cta/badge-' . $prizePack->badgeColor() . '.png')}} 1x, {{ asset('assets/frontend/img/cta/badge-' . $prizePack->badgeColor() . '@2x.png')}} 2x" alt=""> --}}

                                                <span class="{{ $prizePack->badgeColor() }}"><i class="fl fl-badge"></i></span>
			                                </div>
			                                <div class="cta-wrapper text-center">
			                                    <p class="cta-title text-uppercase">{{$prizePack->name}}</p>
                                                <div>
                                                    <p class="cta-text">{{$prizePack->short_description}}</p>
                                                </div>
			                                </div>
			                                <div class="cta-wrapper text-center">
                                                <div class="cta-link-block">
                                                    <div class="badge">{!! $prizePack->price == 0 ? "FREE" : "£".$prizePack->price . " <small>PER TEAM</small>" !!}</div>
                                                </div>
			                                    @if($prizePack->long_description)
				                                    <div class="cta-link-block">
			                            				<a href="{{route('manager.division.prizepack.details', ['division' => $division, 'prizepack' => $prizePack])}}" data-prize-pack-id="{{$prizePack->id}}" class="open_modal_box link-nostyle">
				                                      		<span><i class="fl fl-info"></i></span>
			                            				</a>
				                                    </div>
			                                    @endif
			                                </div>
			                            </div>

	                            @endforeach
	                        </div>
	                    </div>
	                    <div class="row mb-3 justify-content-center">
	                        <div class="col-12 col-md-10 col-lg-7">
	                            <button type="submit" class="btn btn-primary btn-block js-prize-pack-done">
	                                Done
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
