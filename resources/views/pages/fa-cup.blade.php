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
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="standings-tab" data-toggle="pill" href="#standings" role="tab" aria-controls="standings" aria-selected="true">Standings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="rounds-tab" data-toggle="pill" href="#rounds" role="tab" aria-controls="rounds" aria-selected="false">Rounds</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="standings" role="tabpanel" aria-labelledby="standings-tab">
                                    <div class="table-responsive">
                                        <table class="table custom-table table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th></th>
                                                    <th>Points</th>
                                                    <th>GLS</th>
                                                    <th>ASS</th>
                                                    <th>CS</th>
                                                    <th>GA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Richard's Team</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Richard stenson</a></div>
                                                    </td>
                                                    <td>26</td>
                                                    <td>5</td>
                                                    <td>2</td>
                                                    <td>3</td>
                                                    <td>54</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Untappedtalent United</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Stuart Waish</a></div>
                                                    </td>
                                                    <td>23</td>
                                                    <td>3</td>
                                                    <td>5</td>
                                                    <td>2</td>
                                                    <td>54</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Oh not again</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Chris Cragg</a></div>
                                                    </td>
                                                    <td>22</td>
                                                    <td>6</td>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>35</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Citizen Kane</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Ben Grout</a></div>
                                                    </td>
                                                    <td>252</td>
                                                    <td>42</td>
                                                    <td>24</td>
                                                    <td>34</td>
                                                    <td>35</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Ham Saladyce</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">5asideorg</a></div>
                                                    </td>
                                                    <td>221</td>
                                                    <td>31</td>
                                                    <td>23</td>
                                                    <td>39</td>
                                                    <td>35</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Dominic's Team</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Dominic van den Bergh</a></div>
                                                    </td>
                                                    <td>173</td>
                                                    <td>37</td>
                                                    <td>21</td>
                                                    <td>16</td>
                                                    <td>35</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Gonnertasary Wanderers</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Ed Will</a></div>
                                                    </td>
                                                    <td>145</td>
                                                    <td>25</td>
                                                    <td>28</td>
                                                    <td>21</td>
                                                    <td>35</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="rounds" role="tabpanel" aria-labelledby="rounds-tab">
                                    <div class="table-responsive">
                                        <table class="table custom-table table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th></th>
                                                    <th>Points</th>
                                                    <th>GLS</th>
                                                    <th>ASS</th>
                                                    <th>CS</th>
                                                    <th>GA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Richard's Team</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Richard stenson</a></div>
                                                    </td>
                                                    <td>26</td>
                                                    <td>5</td>
                                                    <td>2</td>
                                                    <td>3</td>
                                                    <td>54</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Untappedtalent United</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Stuart Waish</a></div>
                                                    </td>
                                                    <td>23</td>
                                                    <td>3</td>
                                                    <td>5</td>
                                                    <td>2</td>
                                                    <td>54</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Oh not again</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Chris Cragg</a></div>
                                                    </td>
                                                    <td>22</td>
                                                    <td>6</td>
                                                    <td>1</td>
                                                    <td>1</td>
                                                    <td>35</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Citizen Kane</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Ben Grout</a></div>
                                                    </td>
                                                    <td>252</td>
                                                    <td>42</td>
                                                    <td>24</td>
                                                    <td>34</td>
                                                    <td>35</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Ham Saladyce</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">5asideorg</a></div>
                                                    </td>
                                                    <td>221</td>
                                                    <td>31</td>
                                                    <td>23</td>
                                                    <td>39</td>
                                                    <td>35</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">-</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">-</a></div>
                                                    </td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Gonnertasary Wanderers</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Ed Will</a></div>
                                                    </td>
                                                    <td>145</td>
                                                    <td>25</td>
                                                    <td>28</td>
                                                    <td>21</td>
                                                    <td>35</td>
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
