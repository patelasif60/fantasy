@can('accessPreAuctionState', [$division, true])
@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/divisions/preauction/index.js') }}"></script>
@endpush

<div class="cta-block-preauction-wrapper mb-3">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="cta-block-preauction text-white">
                <div class="cta-wrapper">
                    <div class="cta-detail">
                        <p class="cta-title">{{$division->name}}</p>
                        <div class="cta-link">
                            @can('update', $division)
                                @if(isset($page) && $page == 'team')
                                    <a href="javascript:void(0);" class="show-league-rules-data" data-url="{{ route('manage.division.rules.data',['division' => $division]) }}">
                                    League Rules
                                    </a>
                                @else
                                    <a href="{{ route('manage.division.settings',['division' => $division]) }}">
                                    League Settings
                                    </a>
                                    <br>
                                    @can('checkMaxTeamsQuota', $division)
                                        <a href="{{ route('manage.division.create.team',['division' => $division]) }}">
                                        Add Team
                                        </a>
                                    @endcan
                                @endif
                            @else
                                <a href="javascript:void(0);" class="show-league-rules-data" data-url="{{ route('manage.division.rules.data',['division' => $division]) }}">
                                League Rules
                                </a>
                            @endcan

                        </div>
                    </div>
                    <div class="cta-add-friend text-center">
                        <div class="cta-link">
                            <a href="javascript:void(0);" data-url="{{ route('manage.division.invite.data',['division' => $division]) }}" class="show-invite-friends-data">
                                <div class="icon-add">
                                    <img src="{{asset('assets/frontend/img/auction/add-user.svg')}}" alt="Invite Friend">
                                </div>
                                Invite a friend
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('modals')
   <div class="modal fade" id="modal-create-edit-box" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
    </div>
@endpush

@endcan
