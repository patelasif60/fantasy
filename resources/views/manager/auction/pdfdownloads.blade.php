@extends('layouts.manager')

@include('partials.manager.leagues')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ url()->previous() }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li class="has-dropdown js-has-dropdown-division cursor-pointer"> {{  $division->name }} <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span></li>
                    <li class="text-right"></li>
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
                        <div class="mb-5 mb-100 text-white">
                                <div class="mt-5">
                                    <p><a class="text-white" href="{{ $auctionPackPdfDownload['auction_tracker_pdf'] }}" download>Download Auction Tracker (PDF)</a></p>
                                    <p><a class="text-white" href="{{ $auctionPackPdfDownload['team_sheet_horizontal_pdf'] }}" download>Download Team Sheet - Horizontal (PDF)</a></p>
                                    <p><a class="text-white" href="{{ $auctionPackPdfDownload['team_sheet_vertical_pdf'] }}" download>Download Team Sheet - Vertical (PDF)</a></p>
                                    <p><a class="text-white" href="{{route('manage.more.players.export_xlsx',['division' => $division])}}" download>Download Player List (PDF)</a></p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
