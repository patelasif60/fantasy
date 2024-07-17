@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('plugin-scripts')
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary my-1" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="league-tab" data-toggle="pill" href="#league" role="tab" aria-controls="league" aria-selected="true">League</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="team-tab" data-toggle="pill" href="#team" role="tab" aria-controls="team" aria-selected="false">Team</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="player-tab" data-toggle="pill" href="#weekly" role="tab" aria-controls="weekly" aria-selected="false">Players</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12">
                            <div class="tab-content mt-3" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="league" role="tabpanel" aria-labelledby="league-tab">
                                    <ul class="custom-list-group list-group-white mb-5">
                                        <li>
                                            <div class="list-element">
                                                <span>League Budget</span>
                                                <span>£100m</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="list-element">
                                                <span>Club Quota</span>
                                                <span>2 per club</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="list-element">
                                                <span>Squad Size</span>
                                                <span>15</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="list-element">
                                                <span>Allowed Formations</span>
                                                <span class="f-12">4-4-2, 5-3-2, 4-5-1 5-4-1, 4-3-3</span>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="row justify-content-center">
                                        <div class="col-10">
                                            <p class="text-center f-14 text-white">Get a league report emailed to you containing your full league standings, head to head results, form guide and complete list of free agents.</p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-10">
                                            <button type="button" class="btn btn-outline-white btn-block mb-3">Email report</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="team-tab">
                                    <div class="sliding-area">
                                        <div class="sliding-nav">
                                            <div class="sliding-items">
                                                <div class="owl-carousel owl-theme">
                                                    @for ($i=0; $i<30; $i++)
                                                        <div class="item sliding-item is-small">
                                                            <a href="javascript:void(0)" class="sliding-crest with-shadow">
                                                                <img class="lazyload" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="//randomuser.me/api/portraits/men/{{ $i }}.jpg" alt="">
                                                            </a>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sliding-area">
                                        <div class="sliding-nav">
                                            <div class="sliding-items">
                                                <div class="owl-carousel owl-theme sliding-items-info">
                                                    @for ($i=0; $i<30; $i++)
                                                        <div class="item info-block">
                                                            <a href="javascript:void(0)" class="info-block-content">
                                                                <div class="block-section">
                                                                    <div class="title">
                                                                        29/01
                                                                    </div>
                                                                    <div class="desc">
                                                                        19:45
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="crest-info">
                                        <div class="crest-icon">
                                            <img class="lazyload" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="//randomuser.me/api/portraits/men/0.jpg" alt="">
                                        </div>
                                        <div class="crest-name text-white">
                                            <div class="font-weight-bold">Richard’s Team</div>
                                        </div>
                                    </div>
                                    <ul class="custom-list-group list-group-white">
                                        <li>
                                            <div class="list-element">
                                                <span>Remaining budget</span>
                                                <span>£5m</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="list-element">
                                                <span>Manager</span>
                                                <span>Richard Stenson</span>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="table-responsive">
                                        <table class="table custom-table table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th></th>
                                                    <th>£M</th>
                                                    <th>Points</th>
                                                    <th>PLD</th>
                                                    <th><span class="custom-badge custom-badge-primary is-circle">G</span></th>
                                                    <th><span class="custom-badge custom-badge-secondary is-circle">A</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="player-wrapper">
                                                            <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                            <div>
                                                                <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                <br>
                                                                <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>7.50</td>
                                                    <td>17</td>
                                                    <td>19</td>
                                                    <td>0</td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="player-wrapper">
                                                            <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>

                                                            <div>
                                                                <a href="#" class="team-name link-nostyle">Kepa</a>
                                                                <br>
                                                                <a href="#" class="player-name link-nostyle small">Chelsea</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>1.00</td>
                                                    <td>43</td>
                                                    <td>20</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="player-wrapper">
                                                            <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>
                                                            <div>
                                                                <a href="#" class="team-name link-nostyle">Allisson</a>
                                                                <br>
                                                                <a href="#" class="player-name link-nostyle small">Liverpool</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>1.50</td>
                                                    <td>4</td>
                                                    <td>13</td>
                                                    <td>2</td>
                                                    <td>-2</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="player-tab">
                                    <div class="form-group">
                                        <div class="row gutters-sm text-white">
                                            <div class="col-6">
                                                <label for="position">Position</label>
                                                <select class="form-control" id="date">
                                                    <option>All</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label for="position">Club</label>
                                                <select class="form-control" id="date">
                                                    <option>All</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table custom-table table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>£M</th>
                                                    <th>Points</th>
                                                    <th>PLD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="player-wrapper">
                                                            <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                            <div>
                                                                <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                <br>
                                                                <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Richard's Team</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Richard Stenson</a></div>
                                                    </td>
                                                    <td>7.50</td>
                                                    <td>17</td>
                                                    <td>19</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="player-wrapper">
                                                            <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>

                                                            <div>
                                                                <a href="#" class="team-name link-nostyle">Kepa</a>
                                                                <br>
                                                                <a href="#" class="player-name link-nostyle small">Chelsea</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Untappedtalent</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Stuart Walsh</a></div>
                                                    </td>
                                                    <td>1.00</td>
                                                    <td>43</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="player-wrapper">
                                                            <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>
                                                            <div>
                                                                <a href="#" class="team-name link-nostyle">Allisson</a>
                                                                <br>
                                                                <a href="#" class="player-name link-nostyle small">Liverpool</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">5asideorg</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">5asidelads</a></div>
                                                    </td>
                                                    <td>1.50</td>
                                                    <td>4</td>
                                                    <td>13</td>
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
        </div>
    </div>

@endsection
