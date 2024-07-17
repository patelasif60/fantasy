<div class="tab-content mt-3" id="pills-tabContent">
    <div class="tab-pane fade show active" id="league" role="tabpanel" aria-labelledby="league-tab">
        <ul class="custom-list-group list-group-white mb-5">
            <li>
                <div class="list-element">
                    <span>League Budget</span>
                    <span>@if($budget) £{{$budget}}m @endif</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Club Quota</span>
                    <span>@if($quota) {{$quota}} per club @endif</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Squad Size</span>
                    <span>@if($squad) {{$squad}}  @endif</span>
                </div>
            </li>
            <li>
                <div class="list-element">
                    <span>Allowed Formations</span>
                    <span class="f12">@if($formations) {{$formations}}  @endif</span>
                </div>
            </li>
        </ul>
        <p class="text-center text-white">Get a league report emailed to you containing your full league standings, head to head results, form guide and complete list of free agents.</p>
        <button type="button" class="btn btn-outline-white btn-block mb-3" data-url="{{route('manage.leaguereports.division.email',['division' => $division])}}" id="sendEmail">Email report</button>
        <div class="d-none" id="fadeMe">
            <div class="custom-alert alert-danger text-dark text-center">
                <div class="alert-icon">
                    <img  src="{{ asset('/assets/frontend/img/cta/icon-whistle.svg') }}" alt="alert-img">
                </div>
                <div class="alert-text text-dark">
                  League - {{$division->name}} report will be sent to you soon.
                </div>
            </div>
        </div>
    </div>
</div>