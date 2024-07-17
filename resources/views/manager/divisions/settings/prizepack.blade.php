@extends('layouts.manager-league-settings')

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/prize_pack_selection.js') }}"></script>
@endpush

@section('page-name')
Select Your Prize Pack
@endsection

@section('right')
	<form class="js-select-prize-pack-form" action="{{ route('manage.division.prizepack.update', ['division' => $division]) }}" method="post">
        {{ csrf_field() }}
        <div class="row mt-1 mb-5">
            <div class="col-12">
                @foreach($prizePacks as $prizePack)
                    <div class="js-select-prize-pack cta-block @if($division->prize_pack){{ $prizePack->id == $division->prize_pack ? 'active' : '' }} @else {{ $defaultPackagePrizePack == $prizePack->id ? 'active' : '' }} @endif">
                            <input class="d-none" type="radio" name="prize_pack_id" value="{{ $prizePack->id }}" {{ $prizePack->id == $division->prize_pack ? 'checked' : $defaultPackagePrizePack == $prizePack->id ? 'checked' : '' }}>
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
        <div class="row justify-content-center">
            <div class="col-8 col-md-6 col-lg-4">
                <button type="submit" class="btn btn-primary btn-block js-prize-pack-done">
                    Done
                </button>
            </div>
        </div>
    </form>
@endsection

@push('modals')
<div class="modal fade" id="modal-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">

</div>
@endpush
