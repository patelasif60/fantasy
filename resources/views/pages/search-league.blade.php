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
                            <p class="mb-5">You can join a league by searching for the league’s name or by searching for the email address of a league chief executive.</p>

                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="search-by-name">League or chairman name</label>
                                    <input type="text" class="form-control" id="search-by-name" name="search-by-name" value="" placeholder="e.g. Magnificent Seven">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
