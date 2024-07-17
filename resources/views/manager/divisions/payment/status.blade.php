@extends('layouts.manager')

@push('header-content')
	<div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar text-center">
                    <li>
                        @if($payment['message'] != 'SUCCESS')
                            <a href="{{ route('manage.division.index') }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                        @endif
                    </li>

                    <li class="text-center">
			Payment
                       @if($payment['message'] == 'SUCCESS') Complete @else Error @endif
                    </li>
                    <li>
                        @can('update', $division)
                            <a href="{{ route('manage.division.settings',['division' => $division ]) }}"> Settings &nbsp;&nbsp;<span><i class="fas fa-chevron-right"></i></span></a>
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
                @if($payment['message'] != 'SUCCESS')
                    <div class="custom-alert alert-danger">
                        <div class="alert-text">
                            An error occured in your payment. Please go back and try again!
                        </div>
                    </div>
                @else
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="payment-text text-white">
                                <p class="mb-4">Thank you for your recent payment to Fantasy League.Your payment has been securely processed.The details of your purchase appear below:</p>

                                <p class="mb-0">Date:  {{carbon_format_to_time($payment['divisionPaymentDetail']->created_at)}}</p>
                                <p class="mb-0">Reference: {{$payment['divisionPaymentDetail']->worldpay_ordercode}}</p>
                                <p>Items:</p>
                                    <ol>
                                        @foreach($payment['teams'] as $team)
                                            @if(count($payment['teams']) != ($payment['teams']['freeCount']+1))
                                                <li>
                                                    {{$team->team->divisionTeam->division->package->name}} (£{{$team->team->divisionTeam->division->package->price}}) &#10005  {{count($payment['teams'])-($payment['teams']['freeCount']+1)}} teams.
                                                </li>
                                            @endif
                                            @if($team->team->divisionTeam->division->prize_pack)
                                                <li>{{$team->team->divisionTeam->division->prizePack->name}} (£{{$team->team->divisionTeam->division->prizePack->price}}) &#10005  {{count($payment['teams'])-1}} teams.</li>
                                            @endif
                                        @break
                                        @endforeach
                                    </ol>
                                <p class="mb-0">Total : £{{$payment['divisionPaymentDetail']->amount}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="container-body">
                    {{-- <ul class="custom-list-group list-group-white mb-3">
                    @foreach($division->divisionTeamsWithoutPivot as $divisionTeam)
                    @foreach($payment['teams'] as $team)
                     @if($divisionTeam->team_id == $team->team_id)
                        <li>
                            <div class="list-element">
                                @foreach($division->divisionTeams as $devTeam)
                                     @if($devTeam->id == $team->team_id)
                                        <span>{{$devTeam->name}} - {{$division->package->name}} (£{{$division->package->price}}) {{$division->prize_pack?'- Prize(£'.$division->getPrize().')' :' '}}</span>
                                    @endif
                                @endforeach
                                @if($divisionTeam->is_free)
                                    <span>£{{$division->prizePack->price}}</span>
                                @else
                                    <span>£{{$payment['price']}}</span>
                                @endif

                            </div>
                        </li>
                       @endif
                      @endforeach
                    @endforeach
                        <li class="font-weight-bold">
                            <div class="list-element">
                                <span>Total</span>
                                <span>£{{$payment['divisionPaymentDetail']->amount}}</span>
                            </div>
                        </li>
                    </ul> --}}
                    <div class="receipt-number text-white">{{-- Receipt #{{$payment['divisionPaymentDetail']->id}} --}}</div>
                        <div class="row my-3 justify-content-center">
                            <div class="col-md-4">
                                <a href = "{{ route('manage.division.payment.index',['division' => $division,'type'=>'league'])}}?via={{$via}}" type="button" class="btn btn-primary btn-block" id = "makePayment" data-form="#js-league-team-selection-form">Done</a>
                            </div>
                        </div>
                   </div>
                 </div>
                @endif
        </div>
    </div>
</div>
@endsection

@push('footer-content')
    @include('partials.auth.footer')
@endpush
