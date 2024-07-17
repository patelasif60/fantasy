@extends('layouts.manager')

@push('page-scripts')
<script type="text/javascript" src="https://cdn.worldpay.com/v1/worldpay.js"></script>
<script type="text/javascript" src="{{ asset('js/manager/divisions/payment/payment_league.js')}}"></script>

@endpush
@push('header-content')
	<div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.payment.index',['division' => $division, 'type'=>'league']) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li class="text-center"> Checkout</li>
                    <li class="text-right">
                    	{{-- <a href="{{ route('manage.more.division.index', ['division' => $division ]) }}">
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
<div class="row justify-content-center div-continer division-make-payment">
	<div class="col-12 col-sm-12 col-md-6 col-xl-4">
		<div class="block text-white">
		<form class="js-league-checkout-payment-form" action="{{route('manage.division.payment', ['division' => $division])}}?via={{$via}}"  id = "paymentForm" method="post" data-clientkey={{$clientKey}}>
			{{ csrf_field() }}
			<div class="block-content block-content-full">
				<div class="row d-flex justify-content-center">
					<div id='paymentSection'></div>
				</div>
			</div>
			<div class="block-content block-content-full block-content-sm bg-body-light text-center">
			  <div class="form-group">
				<label for="name" class="required"><h3>Amount - £{{ number_clean($amount) }} </h3></label>
				<button type="submit" class="btn btn-primary btn-block" id = "makePayment" data-form="#paymentForm">Make Payment</button>
              </div>
			</div>
		</form>
		</div>
	</div>
</div>

@endsection
