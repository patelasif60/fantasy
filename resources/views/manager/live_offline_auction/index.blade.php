@extends('layouts.manager')

@include('partials.manager.leagues')

@push('plugin-styles')
    <link rel="stylesheet" id="css-main" href="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@push('plugin-scripts')

    <script src="{{ asset('themes/codebase/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/codebase/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/manager/auction/division_team.js') }}"></script>
    <script>
        var divisionId = @json($division->id);
    </script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                   <li>
                        <a href="{{ route('manage.division.info',['division' => $division ]) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li>
                        {{-- <a href="@if(isset($division) && $division) {{ route('manage.more.division.index', ['division' => $division ]) }} @else {{ route('manage.more.index') }} @endif">
                            <span><i class="fas fa-bars"></i></span>
                        </a> --}}
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-toggle" aria-controls="menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fl fl-bar"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush



@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">

                    <div class="row justify-content-center mt-5">
                        <div class="col-12 col-md-9 col-lg-6 col-xl-5 text-white">
                            @if($division->isAuctionSet() &&
                                    !$division->isPostAuctionState() &&
                                    !$division->isInAuctionState()
                                )
                                    Your league auction is scheduled to begin on
                                    {{carbon_format_view_date($division->auction_date)}} at {{$division->auction_venue}}
                                    Once the auction is completed you will be
                                        able to manage your team.
                                <div class="text-center mt-5">
                                    <a href="{{ $auctionPackPdfDownload['auction_tracker_pdf'] }}" class="btn btn-primary w-75" download>Download Auction Tracker (PDF)</a>
                                    <a href="{{ $auctionPackPdfDownload['team_sheet_horizontal_pdf'] }}" class="btn btn-secondary w-75 mt-5" download>Download Team Sheet - Horizontal (PDF)</a>
                                    <a href="{{ $auctionPackPdfDownload['team_sheet_vertical_pdf'] }}" class="btn btn-secondary w-75 mt-2" download>Download Team Sheet - Vertical (PDF)</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="js-table-division-teams-url" data-url="{{ route('get.auction.division.teams',['division' => $division ]) }}">

                                @if($division->isAuctionSet()
                                    && $division->isInAuctionState())
                                    <div class="table-responsive">
                                        <table class="table custom-table m-0 js-table-division-teams">

                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($division->isAuctionSet() && !$division->isPostAuctionState())
                        @can('update', $division)
                              <form action="" method="GET">
                                    @csrf
                                    <div class="text-center mt-5">
                                       <a href="javascript:void(0)" data-url="{{ route('manage.division.team.auction.close', ['division' => $division]) }}" class="btn btn-primary close-auction-confirmation-button @if(!$division->allTeamsSquadFull())  disabled @endif">Close auction</a>
                                    </div>
                              </form>
                        @endcan
                    @endif
            </div>
        </div>
    </div>

@endsection
