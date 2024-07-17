<nav class="navbar fixed-top">
    <div class="watermark">
        <img src="{{ asset('/frontend/img/other/fl-watermark.svg')}}" alt="">
    </div>
    <div class="color-layer"></div>
    <div class="players">
        <div class="container-fluid">
            <div class="players-images bm-multiply js-carousel">
                <div class="pl-img-item" data-aos="fade-right" data-aos-delay="20" data-aos-disable="phone">
                    <img src="{{ asset('/frontend/img/players/Son-Heung-Min_01.png') }}" alt="Son Heung Min">
                </div>
                <div class="pl-img-item" data-aos="fade-left" data-aos-delay="10" data-aos-disable="phone">
                    <img src="{{ asset('/frontend/img/players/Virgil-Van-Dijk_02.png') }}" alt="Virgil Van">
                </div>
                <div class="pl-img-item" data-aos="fade-left" data-aos-delay="30" data-aos-disable="phone">
                    <img src="{{ asset('/frontend/img/players/FL_Sergio-Aguero_03.png') }}" alt="Sergio Aguero">
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ Route('frontend') }}">
            <div class="brand-logo">
                <div class="brand-img">
                    {{-- <img src="{{ asset('/frontend/img/logo/fl-logo.svg') }}" alt=""> --}}
                    <span class="logo-star">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 71.26 86">
                            <style type="text/css">
                                .st0{fill:#ED9524;}
                            </style>

                            <g>
                                <g id="Logo">
                                    <polyline class="st0" points="25.2,44 28.1,42 24.6,42 23.5,38.6 22.4,42 18.8,42 21.7,44 20.6,47.4 23.5,45.3 26.3,47.4 25.2,44
                                                "/>
                                    <polyline class="st0" points="37.4,44 40.3,42 36.7,42 35.6,38.6 34.5,42 31,42 33.9,44 32.8,47.4 35.6,45.3 38.5,47.4 37.4,44
                                        "/>
                                    <polyline class="st0" points="49.6,44 52.4,42 48.9,42 47.8,38.6 46.7,42 43.2,42 46,44 44.9,47.4 47.8,45.3 50.7,47.4 49.6,44
                                        "/>
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="logo-big">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 71.26 86">
                            <defs><style>.stars{fill:#009b2d;}.fl-el{fill:#ed9524;}</style></defs>

                            <g id="Layer_2" data-name="Layer 2">
                                <g id="Logo">
                                    <path class="stars" d="M21.22,44.17,26.48,30.6l13.57,5.31-5.7,2.46-5-2-2.24,5.77,8.08,3.16-1.45,3.75Zm42.29-16-14,36.11L60,68.3l0,.08-5.17,2.23-11-4.21L60.08,24.46c-.38-.36-.77-.71-1.17-1.06L42.43,65.87l-.52,1.35,1.37.53,9.58,3.67-5.67,2.45L35.63,69.42,54.7,20.27A35.64,35.64,0,0,0,5,68.65L22.61,23.37,47,32.9l-5.1,2.2-16.3-6.38L8.34,73.29c.35.42.72.83,1.09,1.24l11.26-29,12.56,4.89-1.42,3.65L23.75,50.9,13.21,78.06a35.63,35.63,0,0,0,50.3-49.88"/><polyline class="fl-el" points="25.07 5.44 27.94 3.37 24.4 3.37 23.31 0 22.22 3.37 18.68 3.37 21.55 5.44 20.44 8.81 23.31 6.72 26.18 8.81 25.07 5.44"/><polyline class="fl-el" points="37.24 5.44 40.11 3.37 36.57 3.37 35.48 0 34.39 3.37 30.86 3.37 33.72 5.44 32.62 8.81 35.48 6.72 38.35 8.81 37.24 5.44"/>
                                    <polyline class="fl-el" points="49.42 5.44 52.28 3.37 48.74 3.37 47.65 0 46.56 3.37 43.03 3.37 45.89 5.44 44.79 8.81 47.65 6.72 50.52 8.81 49.42 5.44"/>
                                </g>
                            </g>
                        </svg>
                    </span>
                </div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#FL-Menu" aria-controls="FL-Menu" aria-expanded="false" aria-label="Toggle navigation">
            <div class="nav-btn">
                <span class="fl fl-bar"></span>
            </div>
        </button>

        <div class="collapse navbar-collapse" id="FL-Menu">
            <ul class="navbar-nav">
                <li class="nav-item {{ Request::is('frontend/rules') ? 'active' : ''}}" data-aos="fade-up" data-aos-delay="20">
                    <a href="{{ Route('frontend/rules') }}" class="nav-link">Game Rules</a>
                </li>
                 <li class="nav-item {{ Request::is('frontend/rules') ? 'active' : ''}}" data-aos="fade-up" data-aos-delay="20">
                    <a href="{{ Route('frontend.gameguide') }}" class="nav-link">GAME GUIDE</a>
                </li>
                <li class="nav-item {{ Request::is('frontend/about') ? 'active' : ''}}" data-aos="fade-up" data-aos-delay="25">
                    <a href="{{ Route('frontend/about') }}" class="nav-link">About</a>
                </li>
                <li class="nav-item {{ Request::is('frontend/contact') ? 'active' : ''}}" data-aos="fade-up" data-aos-delay="30">
                    <a href="{{ Route('frontend/contact') }}" class="nav-link">Contact</a>
                </li>
                <li class="nav-item {{ Request::is('frontend/terms') ? 'active' : ''}}" data-aos="fade-up" data-aos-delay="35">
                    <a href="{{ Route('frontend/terms') }}" class="nav-link" style="text-transform: none;">T&Cs</a>
                </li>
                <li class="nav-item {{ Request::is('frontend/privacy') ? 'active' : ''}}" data-aos="fade-up" data-aos-delay="40">
                    <a href="{{ Route('frontend/privacy') }}" class="nav-link">Privacy Policy</a>
                </li>
                @if (Auth::check())
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="40">
                        <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
{{-- <div class="navigation">
    <div class="container">
        <div class="navigation-bar navbar-expand-xl">
            <div class="brand-logo">
                <a href="" class="brand-img">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 71.26 86"><defs><style>.stars{fill:#009b2d;}.fl-el{fill:#ed9524;}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Logo"><path class="stars" d="M21.22,44.17,26.48,30.6l13.57,5.31-5.7,2.46-5-2-2.24,5.77,8.08,3.16-1.45,3.75Zm42.29-16-14,36.11L60,68.3l0,.08-5.17,2.23-11-4.21L60.08,24.46c-.38-.36-.77-.71-1.17-1.06L42.43,65.87l-.52,1.35,1.37.53,9.58,3.67-5.67,2.45L35.63,69.42,54.7,20.27A35.64,35.64,0,0,0,5,68.65L22.61,23.37,47,32.9l-5.1,2.2-16.3-6.38L8.34,73.29c.35.42.72.83,1.09,1.24l11.26-29,12.56,4.89-1.42,3.65L23.75,50.9,13.21,78.06a35.63,35.63,0,0,0,50.3-49.88"/><polyline class="fl-el" points="25.07 5.44 27.94 3.37 24.4 3.37 23.31 0 22.22 3.37 18.68 3.37 21.55 5.44 20.44 8.81 23.31 6.72 26.18 8.81 25.07 5.44"/><polyline class="fl-el" points="37.24 5.44 40.11 3.37 36.57 3.37 35.48 0 34.39 3.37 30.86 3.37 33.72 5.44 32.62 8.81 35.48 6.72 38.35 8.81 37.24 5.44"/><polyline class="fl-el" points="49.42 5.44 52.28 3.37 48.74 3.37 47.65 0 46.56 3.37 43.03 3.37 45.89 5.44 44.79 8.81 47.65 6.72 50.52 8.81 49.42 5.44"/></g></g></svg>
                    </span>
                </a>
            </div>
            <div class="nav-btn">
                <span class="fl fl-bar"></span>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link">Game Rules</a>
                    </li>
                    <li class="nav-item active">
                        <a href="#" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">T&C’S</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Privacy Policy</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}
{{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 397.39"><defs><style>.cls-1{fill:#f5f5f5;}</style></defs><title>shape</title><g id="Layer_2" data-name="Layer 2"><g id="Menu_Overlay" data-name="Menu Overlay"><polygon class="cls-1" points="0 397.39 1024 397.39 0 0 0 397.39"/></g></g></svg> --}}
