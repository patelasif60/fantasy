@extends('public-website.layouts.default')

@push('plugin-styles')
@endpush

@push('plugin-scripts')
@endpush

@push('page-scripts')
@endpush

@section('content')
<section>
    <div class="container-fluid" data-aos="fade-down">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="keypoint-section mt-5 mb-5">
                    <h4 class="keypoint-title">GameGuide</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
				<div class="nav flex-column nav-pills" id="tabs" role="tablist" aria-orientation="vertical">
					@php $index = 0; @endphp
					@foreach($gameGuide as $key => $guide)
						<a class="nav-link {{ ($index == 0) ? 'active' : '' }}" id="tab{{$key}}" data-toggle="pill" href="#target{{$key}}" role="tab" aria-controls="target{{$key}}" aria-selected="{{ ($index == 0) ? true : false }}">{{$guide->section}}</a>
						@php $index++; @endphp
					@endforeach
				</div>
			</div>
			<div class="col-12 col-md-8 col-lg-9 col-xl-10 mt-4 mt-md-0">
				<div class="tab-content" id="tabContent">
					@php $index = 0; @endphp
					@foreach($gameGuide as $key => $guide)
						<div class="tab-pane fade {{ ($index == 0) ? 'show active' : '' }}" id="target{{$key}}" role="tabpanel" aria-labelledby="target{{$key}}">
							<div class="px-3 px-md-0">
								{!!$guide->content!!}
							</div>
						</div>
						@php $index++; @endphp
					@endforeach
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('modals')
@endpush