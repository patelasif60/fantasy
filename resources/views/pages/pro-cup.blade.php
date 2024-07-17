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
                            <div class="table-responsive">
                                <table class="table custom-table table-hover">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div><a href="#" class="team-name link-nostyle">Citizen Kane</a></div>
                                                <div class="small"><a href="#" class="player-name link-nostyle">Ben Grout</a></div>
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>
                                                <div><a href="#" class="team-name link-nostyle">Hopeless Eleven</a></div>
                                                <div class="small"><a href="#" class="player-name link-nostyle">Nick Goodmaker</a></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div><a href="#" class="team-name link-nostyle">Citizen Kane</a></div>
                                                <div class="small"><a href="#" class="player-name link-nostyle">Ben Grout</a></div>
                                            </td>
                                            <td>14</td>
                                            <td>9</td>
                                            <td>
                                                <div><a href="#" class="team-name link-nostyle">One Pound Fish</a></div>
                                                <div class="small"><a href="#" class="player-name link-nostyle">Neil Mosafi</a></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
