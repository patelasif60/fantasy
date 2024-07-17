@extends('layouts.manager')

@push('page-scripts')
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/jquery-validation/additional-methods.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manager/divisions/payment/team_selection.js')}}"></script>
@endpush
@push('header-content')
	<div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.payment.index',['division' => $division,'type'=>'league']) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li class="text-center">
                        {{  $division->name }}</li>
                    <li>
                        @can('update', $division)
                            <a href="{{ route('manage.division.settings',['division' => $division ,'via']) }}"> Settings &nbsp;&nbsp;<span><i class="fas fa-chevron-right"></i></span></a>
                        @endcan
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush
@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-8">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <form class="js-league-team-selection-form" action="{{route('manage.division.payment.checkout', ['division' => $division])}}"  id = "js-league-team-selection-form" method="post" >
                                <input type='hidden' name='selectedTeam' value='{{$teamId}}' />
                                <input type='hidden' name='selectPrize' id="selectPrize" value='{{$prize}}' />
					        {{ csrf_field() }}
                            @foreach($unpaidTeams as $team)
                            @if($team->team->isPaid() === true)
                            @else
                           <label class="team-management-stepper team-payment-block block_{{$loop->iteration}} @if($team->manager_id == $user->consumer->id)
                            firstBlock d-none
                            @endif">
                                <div class="team-management-block">


                                        <div class="team-detail-wrapper">
                                            <p class="team-title">
                                               {{ $team->team->consumer->user->first_name }} {{ $team->team->consumer->user->last_name }} <span class="font-weight-normal small pl-1"> {{ $team->team->name }} </span>
                                            </p>
                                        @if(!$team->team->isPaid())
                                                <p class="team-amount text-dark mb-0">£{{$price}} outstanding</p>
                                            </div>
                                            <div class="team-selection-payment">
                                                <div class="custom-control custom-checkbox">
                                                    <input {{ $team->team->id == $teamId ? 'checked' : ' '}} value="{{$price}}" type="checkbox" class="custom-control-input teams"  name="teams[{{$team->team->id}}]{{$team->team->id}}" id="team-{{$team->team->id}}" >
                                                    <label class="custom-control-label" for="team-{{$team->team->id}}"></label>
                                                </div>
                                            </div>
                                        @elseif($team->team->isPaid() === true)
                                            {{-- <p class="paid-team text-dark mb-0">
                                                Paid <span class="ml-1"><i class="fas fa-check-circle"></i></span>
                                            </p>
                                            </div>
                                            <div class="team-selection-payment"></div> --}}
                                        @else
                                             <p class="paid-team text-dark mb-0">
                                                 <span class="ml-1"></span> <strike>£ {{$price}}</strike> Free  £ {{ $team->team->getPrize()>0 ? $team->team->getPrize().' outstanding' : '' }}
                                             </p>

                                            </div>
                                            <div class="team-selection-payment">
                                                @if($team->team->getPrize()>0)
                                                    <div class="custom-control custom-checkbox">
                                                        <input {{ $team->team->id == $teamId ? 'checked' : ' '}} value="{{ $team->team->getPrize() }}" type="checkbox" class="custom-control-input teams"  name="teams[{{$team->team->id}}]{{$team->team->id}}" id="team-{{$team->team->id}}" >
                                                        <label class="custom-control-label" for="team-{{$team->team->id}}"></label>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                </div>
                            </label>
                            @endif
                            @endforeach
                            <input type = "hidden" id = "price" name = "price" value = "">
							<button type="submit" class="btn btn-primary btn-block" id = "makePayment" data-form="#js-league-team-selection-form">Checkout - £<span id = "lblAmount"  name = "lblAmount">{{ $prize>0?$prize:'0.00' }}</span></button>
                            </form>
                        </div>
                    </div>

                </div>
        </div>
</div>
@endsection
