<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content theme-modal">
            <div class="modal-close-area">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                </button>
                <div class="f-12">Close</div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">League Rules</h5>
            </div>
            {{-- <div class="modal-body pt-0"> --}}
                <ul class="custom-list-group list-group-white is-league-rule text-dark">
                    <li>
                        <div class="list-element text-dark">
                            <span>Auction Budget</span>
                            <span>@if($seasonBudget) £{{$seasonBudget}}m @else -- @endif</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-element text-dark">
                            <span>Season Budget</span>
                            <span>@if($budget) £{{$budget}}m @else -- @endif</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-element text-dark">
                            <span>Rollover Auction Budget</span>
                            <span>@if($isBudgetRollover) Yes @else No @endif</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-element text-dark">
                            <span>Club Quota</span>
                            <span>@if($quota) {{$quota}} per club @else -- @endif</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-element text-dark">
                            <span>Squad Size</span>
                            <span>@if($squad) {{$squad}} @else -- @endif</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-element text-dark">
                            <span>Allowed Formations</span>
                            <span class="small">@if($formations) {{$formations}} @else -- @endif</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-element text-dark">
                            <span>Block Weekend Changes?</span>
                            <span>@if($hasWeekendChanges) No @else Yes @endif</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-element text-dark">
                            <span>Transfers Allowed Per Season</span>
                            <span>@if($seasonTransfer) {{$seasonTransfer}} @else -- @endif</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-element text-dark">
                            <span>Transfers Allowed Per Month</span>
                            <span>@if($monthlyTransfer) {{$monthlyTransfer}} @else -- @endif</span>
                        </div>
                    </li>
                    <li>
                        <div class="list-element text-dark">
                            <span>Transfers Allowed?</span>
                            <span>@if($isAllowedTransfer) Yes @else No @endif</span>
                        </div>
                    </li>
                </ul>
            {{-- </div> --}}
            <div class="modal-footer justify-content-center">
                <a class="btn btn-secondary" href="{{route('manage.division.rules.scoring',['division' => $division])}}">Scoring System</a>
            </div>
        </div>
    </div>
</div>
