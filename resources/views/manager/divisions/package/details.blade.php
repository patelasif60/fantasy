
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content theme-modal">
        <div class="modal-close-area">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times mr-1"></i></span>
            </button>
            <div class="f-12">Close</div>
        </div>
        <div class="modal-body">
            <table class="border point-settings table">
                <tbody>
                    <tr>
                        <th class="border w-25">Package</th>
                        @foreach($packages as $package)
                            <td class="border font-weight-bold w-25">{{ $package->display_name }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Price</th>
                        @foreach($packages as $package)
                            <td class="border w-25">£{{ $package->price }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <h7 class="font-weight-bold">LEAGUE</h7>
            <table class="border point-settings table">
                <tbody>
                    <tr>
                        <th class="border w-25">Private League</th>
                        @foreach($packages as $package)
                            <td class="border w-25">{{ $package->private_league }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <h7 class="font-weight-bold">AUCTION</h7>
            <table class="border point-settings table">
                <tbody>
                    <tr>
                        <th class="border w-25">Auction Type</th>
                        @foreach($packages as $package)
                            <td class="border w-25">{{ join(array_map('ucwords', $package->auction_types), ' or ') }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Auction Budget (Bids)</th>
                        @foreach($packages as $package)
                            @if($package->allow_auction_budget=='Yes')
                                <td class="border w-25">Customisable</td>
                            @else
                            <td class="border w-25">£{{ $package->pre_season_auction_budget }}m (£{{ (float) $package->pre_season_auction_bid_increment }}m)</td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Season Rollover Budget</th>
                        @foreach($packages as $package)
                            @if($package->allow_rollover_budget=='Yes')
                                <td class="border w-25">Customisable</td>
                            @else
                                <td class="border w-25">{{$package->budget_rollover}}</td>
                            @endif
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <h7 class="font-weight-bold">RULES</h7>
            <table class="border point-settings table">
                <tbody>
                    <tr>
                        <th class="border w-25">Squad Size</th>
                        @foreach($packages as $package)
                            @if($package->custom_squad_size=='Yes')
                                <td class="border w-25">11-18</td>
                            @else
                                <td class="border w-25">{{$package->default_squad_size}}</td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Positions</th>
                        @foreach($packages as $package)
                            <td class="border w-25">
                                @if($package->allow_defensive_midfielders == App\Enums\YesNoEnum::YES && $package->allow_merge_defenders == App\Enums\YesNoEnum::YES)
                                    DF / FB + CB,  MF / DM + MF
                                @elseif ($package->merge_defenders == App\Enums\YesNoEnum::YES && $package->defensive_midfields == App\Enums\YesNoEnum::YES)
                                    DF + DMF + MF
                                @elseif ($package->merge_defenders == App\Enums\YesNoEnum::YES && $package->defensive_midfields == App\Enums\YesNoEnum::NO)
                                    DF + MF
                                @elseif ($package->merge_defenders == App\Enums\YesNoEnum::NO && $package->defensive_midfields == App\Enums\YesNoEnum::YES)
                                    CB + FB + DMF + MF
                                @else
                                    FB + CB, MF
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Formations</th>
                        @foreach($packages as $package)
                            <td class="border w-25">@foreach($package->available_formations as $formation) {{ $loop->first ? '' : ', ' }}{{ $formation }} @endforeach</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Club Quota</th>
                        @foreach($packages as $package)
                            @if($package->custom_club_quota=='Yes')
                                <td class="border w-25">Customisable</td>
                            @else
                                <td class="border w-25">{{$package->default_max_player_each_club}}</td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Scoring</th>
                        @foreach($packages as $package)
                         @if($package->allow_custom_scoring=='Yes')
                                <td class="border w-25">Customisable</td>
                            @else
                                <td class="border w-25">Default</td>
                            @endif
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <h7 class="font-weight-bold">TEAM CHANGES</h7>
            <table class="border point-settings table">
                <tbody>
                    <tr>
                        <th class="border w-25">Season Budget (Bids)</th>
                        @foreach($packages as $package)
                            @if($package->allow_bid_increment=='Yes')
                                <td class="border w-25">Customisable</td>
                            @else
                                <td class="border w-25">£{{ $package->seal_bids_budget }}m (£{{ $package->seal_bid_increment }}m)</td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Sealed Bids</th>
                        @foreach($packages as $package)
                            @if($package->allow_seal_bid_deadline_repeat=='Yes')
                                    <td class="border w-25">Customisable</td>
                            @else
                                <td class="border w-25">{{ $sealedBidDeadLinesEnum[$package->seal_bid_deadline_repeat] }}</td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Allow Weekend Changes</th>
                        @foreach($packages as $package)
                            @if($package->allow_weekend_changes_editable=='Yes')
                                <td class="border w-25">Customisable</td>
                            @else
                                <td class="border w-25">{{$package->allow_weekend_changes}}</td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Supersubs</th>
                        @foreach($packages as $package)
                             @if($package->allow_supersubs=='Yes')
                                    <td class="border w-25">Customisable</td>
                            @else
                                <td class="border w-25">No</td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Transfers</th>
                        @foreach($packages as $package)
                             @if($package->allow_monthly_free_agent_transfer_limit=='Yes' && $package->allow_season_free_agent_transfer_limit == 'Yes')
                                    <td class="border w-25">Customisable</td>
                            @else
                                <td class="border w-25">
                                    Season = {{ $package->season_free_agent_transfer_limit }},
                                    Month = {{ $package->monthly_free_agent_transfer_limit }}
                                </td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Transfers Available</th>
                        @foreach($packages as $package)
                            @if($package->allow_free_agent_transfer_authority =='Yes')
                                <td class="border w-25">{{ $package->free_agent_transfer_authority == \App\Enums\TransferAuthorityEnum::ALL ? 'Chairman or all Managers' : \App\Enums\TransferAuthorityEnum::getDescription($package->free_agent_transfer_authority) }}</td>
                            @else
                                <td class="border w-25">No</td>
                            @endif
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <h7 class="font-weight-bold">EXTRA COMPS / PRIZES</h7>
            <table class="border point-settings table">
                <tbody>
                    <tr>
                        <th class="border w-25">FA Cup</th>
                        @foreach($packages as $package)
                            <td class="border w-25">{{ $package->allow_fa_cup }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">FL Rankings</th>
                        @foreach($packages as $package)
                            <td class="border w-25">{{ $package->display_name == 'Novice' ? 'Novice' : 'Pro & Legend' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Head to Head</th>
                        @foreach($packages as $package)
                            <td class="border w-25">{{ $package->allow_head_to_head}}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Custom Cup</th>
                        @foreach($packages as $package)
                            <td class="border w-25">{{ $package->allow_custom_cup == 'Yes' ? 'Yes (many)' : $package->allow_custom_cup }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Linked Leagues</th>
                        @foreach($packages as $package)
                            <td class="border w-25">{{ $package->allow_linked_league }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="border w-25">Lapel Pins / Medals</th>
                        @foreach($packages as $package)
                            <td class="border w-25">{{ in_array(4, $package->prize_packs) || in_array(5, $package->prize_packs) ? 'Choice included' : 'No' }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <h7 class="font-weight-bold">LEAGUE MANAGEMENT</h7>
            <table class="border point-settings table">
                <tbody>
                    <tr>
                        <th class="border w-25">Chairman</th>
                        @foreach($packages as $package)
                            <td class="border w-25">{{ $package->display_name == 'Novice' ? 'Automated' : 'Automated or Manual' }}</td>
                        @endforeach
                    </tr>
                    {{-- <tr>
                        <th class="border w-25">Support</th>
                        @foreach($packages as $package)
                            <td class="border w-25">Email only</td>
                        @endforeach
                    </tr> --}}
                    <tr>
                        <th class="border w-25">Free New Managers</th>
                        @foreach($packages as $package)
                            <td class="border w-25">{{ $package->max_free_places == $package->maximum_teams ? 0 : $package->max_free_places }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
