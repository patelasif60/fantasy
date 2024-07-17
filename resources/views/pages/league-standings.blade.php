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
                                    <a class="nav-link active" id="season-tab" data-toggle="pill" href="#season" role="tab" aria-controls="season" aria-selected="true">Season</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="monthly-tab" data-toggle="pill" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Monthly</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="weekly-tab" data-toggle="pill" href="#weekly" role="tab" aria-controls="weekly" aria-selected="false">Weekly</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="season" role="tabpanel" aria-labelledby="season-tab">
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
                                                    <td>330</td>
                                                    <td>51</td>
                                                    <td>54</td>
                                                    <td>37</td>
                                                    <td>54</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Untappedtalent United</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Stuart Waish</a></div>
                                                    </td>
                                                    <td>300</td>
                                                    <td>40</td>
                                                    <td>43</td>
                                                    <td>43</td>
                                                    <td>54</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Oh not again</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Chris Cragg</a></div>
                                                    </td>
                                                    <td>289</td>
                                                    <td>62</td>
                                                    <td>35</td>
                                                    <td>28</td>
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
                                <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
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
                                                    <td>330</td>
                                                    <td>51</td>
                                                    <td>54</td>
                                                    <td>37</td>
                                                    <td>54</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Untappedtalent United</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Stuart Waish</a></div>
                                                    </td>
                                                    <td>300</td>
                                                    <td>40</td>
                                                    <td>43</td>
                                                    <td>43</td>
                                                    <td>54</td>
                                                </tr>
                                                <tr>
                                                    <td class="team-player-details">
                                                        <div><a href="#" class="team-name link-nostyle">Oh not again</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Chris Cragg</a></div>
                                                    </td>
                                                    <td>289</td>
                                                    <td>62</td>
                                                    <td>35</td>
                                                    <td>28</td>
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
                                <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                                    Weekly Content goes here
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
