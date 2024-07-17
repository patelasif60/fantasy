@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <form>
                                <div class="row gutters-sm text-white">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="player">Player</label>
                                            <select class="js-player-select2" id="player">
                                                <option value="Select first player">Select first player</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cash">+ Cash (£m)</label>
                                            <input type="text" class="form-control" id="cash" name="cash" placeholder="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="player-transfer-icon text-center">
                                    <img src="{{ asset('assets/frontend/img/transfer/icon-swap-white.png')}}" alt="swap-icon">
                                </div>

                                <div class="row gutters-sm text-white">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="swap-player">Player</label>
                                            <select class="js-swap-player-select2" id="swap-player">
                                                <option value="Select second player">Select second player</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cash">+ Cash (£m)</label>
                                            <input type="text" class="form-control" id="cash" name="cash" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table custom-table table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Team 1</th>
                                                <th>out</th>
                                                <th>Team 2</th>
                                                <th>out</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div><a href="#" class="team-name link-nostyle">Citizen Kane</a></div>
                                                    <div><a href="#" class="player-name link-nostyle small">Ben Grout</a></div>
                                                </td>
                                                <td>
                                                    <div><a href="#" class="team-name link-nostyle">Citizen Kane</a></div>
                                                    <div class="small">+£5m</div>
                                                </td>
                                                <td>
                                                    <div><a href="#" class="team-name link-nostyle">Richard's Team</a></div>
                                                    <div><a href="#" class="player-name link-nostyle small">Richard Stenson</a></div>
                                                </td>
                                                <td>
                                                    <div><a href="#" class="team-name link-nostyle">Ederson</a></div>
                                                    <div class="small">-</div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="icon-edit">
                                                        <a href="" class="text-dark">
                                                            <span><i class="fas fa-pencil"></i></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mb-2 gutters-md">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-outline-white btn-block">Finished</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary btn-block">Add swap</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        $(function () {
            $('.js-player-select2').select2();
            $('.js-swap-player-select2').select2();
        });
    </script>
@endpush

@push('footer-content')
    @include('partials.auth.footer')
@endpush



