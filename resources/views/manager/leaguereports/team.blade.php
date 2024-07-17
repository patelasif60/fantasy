<div class="crest-info">
    <div class="crest-icon">
        <img class="lazyload" src="{{ Arr::get($teamData,'team_crest', asset('assets/frontend/img/default/square/default-thumb-100.png')) }}"  data-src="{{ Arr::get($teamData,'team_crest') }}" alt="">
    </div>
    <div class="crest-name text-white">
        <div class="font-weight-bold">{{ Arr::get($teamData,'team_name') }}</div>
    </div>
</div>
<ul class="custom-list-group list-group-white">
    <li>
        <div class="list-element">
            <span>Remaining budget</span>
            <span>&pound;{{ Arr::get($teamData,'remaining_budget',0) }}m</span>
        </div>
    </li>
    <li>
        <div class="list-element">
            <span>Manager name</span>
            <span>{{ Arr::get($teamData,'manager_name') }}</span>
        </div>
    </li>
</ul>

<input type="hidden" id="team_id" value="{{ Arr::get($teamData,'team_id',null) }}">
<h6 class="text-center mt-3 mb-3 font-weight-bold">Players</h6>
<table class="table table-hover table-vcenter leaguereport-teams-list-table custom-table" data-url="{{ route('manage.leaguereports.teamplayersdata', ['division' => $division]) }}"></table>
