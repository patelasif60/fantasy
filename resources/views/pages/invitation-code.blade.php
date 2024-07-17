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
                            <p class="mb-5">If you have an invitation code, you can enter it into the box below.</p>

                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="invitation-code">Invitation Code</label>
                                    <input type="text" class="form-control" id="invitation-code" name="invitation-code" value="" placeholder="e.g. X578DF148">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
