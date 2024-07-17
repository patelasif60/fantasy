<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="footer-navigation">
                <div class="navigation-tab">
                @php
                    $link = "javascript:void(0)";
                    $tmpTeam = '';
                    if(isset($division) && $division) {
                        $link = route('manage.teams.index',['division' => $division ]);
                        // if(!auth()->user()->can('ownLeagues', $division) && auth()->user()->consumer->ownTeam($division))
                        if (auth()->user()->consumer->ownTeam($division) && $division->auction_closing_date) {
                            if(Carbon\Carbon::parse($division->auction_closing_date)->lessThan(Carbon\Carbon::now())){
                            if (auth()->user()->consumer->ownTeam($division) > 1) {
                                $tmpTeam = auth()->user()->consumer->ownFirstApprovedTeamDetails($division);
                            } else {
                                $tmpTeam = auth()->user()->consumer->ownTeamDetails($division);
                            }
                            $link = route('manage.team.lineup',['division' => $division,'team' => $tmpTeam ]);}
                        }
                    }
                @endphp
                <a class="navigation-link {{ active('manage.teams.*') }}{{ active('manage.team.lineup') }}{{ isset($division) && !auth()->user()->can('ownLeagues', $division) && ($tmpTeam && !$tmpTeam->is_approved) ? ' disabled' : '' }}" href="{{ $link }}">
                    <span class="icon">
                        <i class="fas fa-tshirt"></i>
                    </span>
                    <span>Team</span>
                </a>
                    </div>
                    <div class="navigation-tab">
                        <a class="navigation-link {{ active('manage.division.*') }}{{ isset($division) && !auth()->user()->can('ownLeagues', $division) && ($tmpTeam && !$tmpTeam->is_approved) ? ' disabled' : ''}}" @if(isset($division)) href="{{ route('manage.division.info',['division' => $division ]) }}" @else href="{{ route('manage.division.index') }}" @endif>
                            <span class="icon">
                                <i class="fas fa-trophy"></i>
                            </span>
                            <span>League</span>
                        </a>
                    </div>
                    @if(isset($division))
                        @if(! $division->isPostAuctionState())
                            <div class="navigation-tab">
                                <a class="navigation-link @if(isset($division) && $division){{ active('manage.auction.*') }}{{ isset($division) && !auth()->user()->can('ownLeagues', $division) && ($tmpTeam && !$tmpTeam->is_approved) ? ' disabled' : ''}}" href="{{ route('manage.auction.index',['division' => $division ]) }}" @endif >
                                    <span class="icon">
                                        <i class="fas fa-exchange-alt"></i>
                                    </span>
                                    <span>Auction</span>
                                </a>
                            </div>
                        @else
                            @if(config('fantasy.transfer_feature_live') == 'true')
                                <div class="navigation-tab">
                                        <a class="navigation-link @if(isset($division) && $division){{ active('manage.transfer.*') }}{{ isset($division) && !auth()->user()->can('ownLeagues', $division) && ($tmpTeam && !$tmpTeam->is_approved) ? ' disabled' : ''}}" href="{{ route('manage.transfer.index',['division' => $division ]) }}" @endif >
                                        <span class="icon">
                                            <i class="fas fa-exchange-alt"></i>
                                        </span>
                                        <span>Transfers</span>
                                    </a>
                                </div>
                            @else
                                <div class="navigation-tab">
                                    <a class="navigation-link" href="javascript:void(0)" data-toggle="modal" data-target="#transferModal">
                                        <span class="icon">
                                            <i class="fas fa-exchange-alt"></i>
                                        </span>
                                        <span>Transfers</span>
                                    </a>
                                </div>
                            @endif
                        @endif
                    @endif
                    <div class="navigation-tab">
                        <a class="navigation-link {{ active('manage.stat.*') }}{{ isset($division) && !auth()->user()->can('ownLeagues', $division) && ($tmpTeam && !$tmpTeam->is_approved) ? ' disabled' : ''}}" href="{{ route('manage.matches.index', ['division' => $division ?? null ]) }}">
                            <span class="icon">
                                <i class="fas fa-analytics"></i>
                            </span>
                            <span>Stats</span>
                        </a>
                    </div>
                    <div class="navigation-tab">
                        <a class="navigation-link {{ active('manage.feed.*') }}{{ isset($division) && !auth()->user()->can('ownLeagues', $division) && ($tmpTeam && !$tmpTeam->is_approved) ? ' disabled' : ''}} chatLink" href="{{ route('manage.feed.index', ['division' => $division ?? null ]) }}">
                            <span class="icon">
                                <i class="fas fa-rss"></i>
                                <span class="notification-counter feed-chat-count">
                                    <span class="count"></span>
                                </span>
                            </span>
                            <span>Feed</span>
                        </a>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- <footer id="page-footer" class="bg-white opacity-0">
    <div class="content py-20 font-size-xs clearfix">
        <div class="float-right">
            Site developed by <a class="font-w600" href="https://www.aecordigital.com" target="_blank">aecor</a>
        </div>
        <div class="float-left">
            <a class="font-w600" href="{{ route('landing') }}">{{ config('app.name') }} {{ config('app.version') }}</a> &copy; {{ date('Y') }}</span>
        </div>
    </div>
</footer> --}}

<div id="transferModal" class="modal fade transferModal" role="dialog">>
    <div class="modal-dialog" role="document">
        <div class="modal-content theme-modal">
            <div class="modal-close-area">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
                </button>
                <div class="f-12">Close</div>
             </div>
             <div class="modal-header">
                <h5 class="modal-title">Transfers</h5>
             </div>
             <div class="modal-body">
                The transfers menu will be available by Thursday. Apologies for any inconvenience this may cause.
             </div>
        </div>
    </div>
</div>
