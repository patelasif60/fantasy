@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="results-tab" data-toggle="pill" href="#results" role="tab" aria-controls="results" aria-selected="true">Results & Fixtures</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="premier-league-tab" data-toggle="pill" href="#premier" role="tab" aria-controls="premier" aria-selected="false">Premier League Table</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="results" role="tabpanel" aria-labelledby="results-tab">
                                    <div class="fixture-scheduled-time">
                                        <a href="" class="link-nostyle text-white" data-toggle="modal" data-target="#fixtureModal">
                                            12:30 <span class="ml-2">25th August 2018</span>
                                        </a>
                                    </div>

                                    <div class="fixture-detail-wrapper py-3">
                                        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                            <div class="w-40">
                                                <div class="d-flex align-items-center">
                                                    <div class="team-img che_player"></div>
                                                    <div class="fixture-body text-white ml-2">
                                                        <h6 class="m-0">Brighton</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-white w-20 text-sm-center">
                                                <h6 class="m-0">1:4</h6>
                                            </div>
                                            <div class="w-40"">
                                                <div class="d-flex align-items-center">
                                                    <div class="team-img che_player"></div>
                                                    <div class="fixture-body text-white ml-2">
                                                        <h6 class="m-0">Manchester City</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <div class="w-40">
                                                <div class="team-players text-white">
                                                    <div class="d-flex">
                                                        <span class="custom-badge custom-badge-secondary is-circle">A</span>
                                                        Pascal Gross (90)
                                                    </div>
                                                    <div class="d-flex">
                                                        <span class="custom-badge custom-badge-primary is-circle">G</span>
                                                        Glenn Murray (67)
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="w-40">
                                                <div class="team-players text-white">
                                                    <div class="d-flex">
                                                        <span class="custom-badge custom-badge-primary is-circle">G</span>
                                                        Aymeric Laporte (90)
                                                    </div>
                                                    <div class="d-flex">
                                                        <span class="custom-badge custom-badge-secondary is-circle">A</span>
                                                        Riyad Mahrez (90)
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade fixtureModal" id="fixtureModal" tabindex="-1" role="dialog" aria-labelledby="fixtureModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header align-items-center border-bottom">
                                                    <h6 class="m-0">Match Details</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div>12:30 25th August 2018</div>
                                                    <div class="row mt-2 mb-4">
                                                        <div class="col-5">
                                                            Manchester United
                                                        </div>
                                                        <div class="col-2">
                                                            2 - 1
                                                        </div>
                                                        <div class="col-5">
                                                            Leicester City
                                                        </div>
                                                    </div>

                                                    <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary" id="pills-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="tab1-tab" data-toggle="pill" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Manchester United</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="tab2-tab" data-toggle="pill" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Leicester City</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content" id="pills-tabContent">
                                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                                            <div class="table-responsive">
                                                                <table class="table text-center custom-table">
                                                                    <thead class="thead-dark">
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Status </th>
                                                                            <th>PLS</th>
                                                                            <th>Y/R</th>
                                                                            <th>GLS</th>
                                                                            <th>AST</th>
                                                                            <th>CS</th>
                                                                            <th>GA</th>
                                                                            <th>DF </th>
                                                                            <th>Pts</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="text-dark">David de Gea</td>
                                                                            <td>90</td>
                                                                            <td>0/0</td>
                                                                            <td>0</td>
                                                                            <td>0</td>
                                                                            <td>0</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>8</td>
                                                                            <td>89</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td class="text-center" colspan="10">Substitutes</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td class="text-dark">David de Gea</td>
                                                                            <td>90</td>
                                                                            <td>0/0</td>
                                                                            <td>0</td>
                                                                            <td>0</td>
                                                                            <td>0</td>
                                                                            <td>1</td>
                                                                            <td>1</td>
                                                                            <td>8</td>
                                                                            <td>89</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">...</div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="premier" role="tabpanel" aria-labelledby="premier-league-tab">---</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-content')
    @include('partials.auth.footer')
@endpush
