@extends('layouts.auth.redesign')

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        {{-- <a href="javascript:void(0);" onclick="javascript:history.back();">
                            <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                        </a> --}}
                    </li>
                    <li class="text-center has-dropdown has-arrow">
                        League name
                        <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span>
                    </li>
                    <li class="text-right">
                        {{-- <a href="#">
                            <span><i class="fas fa-cog"></i></span>
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

@push('footer-content')
    @include('partials.auth.footer')
@endpush

@push('plugin-scripts')
@endpush

@push('page-scripts')
    <script>
        $('.has-dropdown').click(function() {
            $('.team-swapping').slideToggle('100');
            $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
        });
    </script>
@endpush

@push('swap-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="team-swapping" class="team-swapping">
                    <div class="sliding-area">
                        <div class="sliding-nav">
                            <div class="sliding-items">
                                <div class="owl-carousel owl-theme">
                                    @for ($i=0; $i<30; $i++)
                                        <div class="item sliding-item is-small">
                                            <a href="javascript:void(0)" class="sliding-crest with-shadow">
                                                <img class="lazyload" src="{{ asset('assets/frontend/img/default/square/default-thumb-100.png')}}" data-src="//randomuser.me/api/portraits/men/{{ $i }}.jpg" alt="">
                                            </a>
                                            <div class="crest-title text-white text-center">Crest Title</div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="auction-listing">
                                <div class="table-responsive">
                                    <table class="table custom-table m-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="text-uppercase">team</th>
                                                <th class="text-center text-uppercase">players</th>
                                                <th class="text-center text-uppercase">budget</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="league-crest"><img src="{{ asset('assets/frontend/img/league/league.svg')}}"></div>

                                                        <div class="ml-2">
                                                            <div><a href="#" class="text-dark link-nostyle">Richard's Team</a></div>
                                                            <div><a href="#" class="link-nostyle small">Richard Stenson</a></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">0</td>
                                                <td class="text-center">200m</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="league-crest"><img src="{{ asset('assets/frontend/img/league/league.svg')}}"></div>

                                                        <div class="ml-2">
                                                            <div><a href="#" class="text-dark link-nostyle">Richard's Team</a></div>
                                                            <div><a href="#" class="link-nostyle small">Richard Stenson</a></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">0</td>
                                                <td class="text-center">200m</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="league-crest"><img src="{{ asset('assets/frontend/img/league/league.svg')}}"></div>

                                                        <div class="ml-2">
                                                            <div><a href="#" class="text-dark link-nostyle">Richard's Team</a></div>
                                                            <div><a href="#" class="link-nostyle small">Richard Stenson</a></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">0</td>
                                                <td class="text-center">200m</td>
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

@endsection

@push ('modals')
@endpush

