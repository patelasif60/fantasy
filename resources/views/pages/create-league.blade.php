@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12 text-white">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="league-name">League Name</label>
                                    <input type="text" class="form-control" id="league-name" name="league-name" placeholder="Awesome League">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Create a League</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
