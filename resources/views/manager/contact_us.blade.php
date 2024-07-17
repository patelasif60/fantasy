@extends('layouts.manager')

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/contactus/create.js') }}"></script>
@endpush

@push('header-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="top-navigation-bar">
                <li>
                    <a href="{{ url()->previous() }}">
                        <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                    </a>
                </li>
                <li class="text-center">Contact Us</li>
                <li class="text-right"></li>
            </ul>
        </div>
    </div>
</div>
@endpush

@section('content')
<form action="{{ route('manage.contactus.store') }}" encytype= "multipart/form-data" method="POST" class="js-contact-form">
	@csrf
	<div class="row align-items-center justify-content-center">
	    <div class="col-12 col-md-10 col-lg-8 col-xl-8">
			@include('flash::custom-message')
	        <div class="container-wrappper">
	            <div class="container-body">
					<div class="row mb-100">
						<div class="col-12 text-white">
							<div class="form-group {{ $errors->has('sender') ? ' is-invalid' : '' }}">
                                <label for="sender" class="required">Sender:</label>
                            	<input type="text" class="form-control" id="sender" name="sender" value="{{ auth()->user()->first_name . ' ' . auth()->user()->last_name . ' (' . auth()->user()->email . ')' }}" readonly="readonly">
                                @if ($errors->has('sender'))
                                    <div class="invalid-feedback animated fadeInDown">
                                        <strong>{{ $errors->first('sender') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('subject') ? ' is-invalid' : '' }}">
                                <label for="subject" class="required">Subject:</label>
                            	<input type="text" class="form-control" id="subject" name="subject" value="">
                                @if ($errors->has('subject'))
                                    <div class="invalid-feedback animated fadeInDown">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('comments') ? ' is-invalid' : '' }}">
                                <label for="comments" class="required">Comments:</label>
								<textarea class="form-control" id="comments" name="comments" rows="6"></textarea>
                                @if ($errors->has('comments'))
                                    <div class="invalid-feedback animated fadeInDown">
                                        <strong>{{ $errors->first('comments') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                            	<button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
						</div>
   					</div>
	            </div>
	        </div>
	    </div>
	</div>
</form>
@endsection
