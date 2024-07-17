<!doctype html>
<!--[if lte IE 9]>
<html lang="en" class="no-focus lt-ie10 lt-ie10-msg">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" class="no-focus bg-white">
    <!--<![endif]-->
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <title>{{ config('app.name', 'Fantasy League') }}</title>
        <meta name="description" content="{{ config('app.description') }}">
        <meta name="author" content="aecor">
        <!-- Open Graph Meta -->
        <meta property="og:title" content="{{ config('app.title', 'Fantasy League') }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Fantasy League') }}">
        <meta property="og:description" content="{{ config('app.description') }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">
        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="/themes/codebase/media/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="/themes/codebase/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/themes/codebase/media/favicons/apple-touch-icon-180x180.png">
        <!-- END Icons -->
        <!-- Stylesheets -->
        <link rel="stylesheet" id="css-main" href="{{ asset('/assets/frontend/css/app.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
        <!-- END Stylesheets -->

    </head>
    <body style="overflow: auto;" class="bg-white">

                <div class="container mt-4">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="progressbar-area">
                                <div class="progessbar-bg">
                                    <div class="bar-block"></div>
                                </div>
                                <ul class="stepper">
                                    <li class="active">Profile</li>
                                    <li>League</li>
                                    <li>Friends</li>
                                    <li>Team</li>
                                </ul>
                            </div>

                            <div class="mt-5"></div>

                            <div class="progressbar-area">
                                <div class="progessbar-bg">
                                    <div class="bar-block"></div>
                                </div>
                                <ul class="stepper">
                                    <li class="completed">Profile</li>
                                    <li class="active">League</li>
                                    <li>Friends</li>
                                    <li>Team</li>
                                </ul>
                            </div>

                            <div class="mt-5"></div>

                            <div class="progressbar-area">
                                <div class="progessbar-bg">
                                    <div class="bar-block"></div>
                                </div>
                                <ul class="stepper">
                                    <li class="completed">Profile</li>
                                    <li class="completed">League</li>
                                    <li class="active">Friends</li>
                                    <li>Team</li>
                                </ul>
                            </div>

                            <div class="mt-5"></div>

                            <div class="progressbar-area">
                                <div class="progessbar-bg">
                                    <div class="bar-block"></div>
                                </div>
                                <ul class="stepper">
                                    <li class="completed">Profile</li>
                                    <li class="completed">League</li>
                                    <li class="completed">Friends</li>
                                    <li class="active">Team</li>
                                </ul>
                            </div>

                            <div class="mt-5"></div>

                            <div class="progressbar-area">
                                <div class="progessbar-bg">
                                    <div class="bar-block"></div>
                                </div>
                                <ul class="stepper">
                                    <li class="completed">Profile</li>
                                    <li class="completed">League</li>
                                    <li class="completed">Friends</li>
                                    <li class="completed">Team</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-4">
                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-uppercase">player</th>
                                    <th class="text-center text-uppercase">bid</th>
                                    <th class="text-center text-uppercase">pld</th>
                                    <th class="text-center text-uppercase">pts</th>
                                    <th class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <span class="custom-badge custom-badge-primary is-circle">G</span>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <span class="custom-badge custom-badge-secondary is-circle">A</span>
                                        </div>
                                    </th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="player-wrapper">
                                            <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                            <div>
                                                <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                <br>
                                                <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">17</td>
                                    <td class="text-center">19</td>
                                    <td class="text-center">0</td>
                                    <td class="text-center">3</td>
                                    <td class="text-center">
                                        <div class="icon-edit"><a href="" class="text-dark" data-toggle="modal" data-target="#edit-bid-modal"><span><i class="fas fa-pencil"></i></span></a></div>
                                    </td>

                                    <!-- Modal -->
                                    <div class="modal fade" id="edit-bid-modal" tabindex="-1" role="dialog" aria-labelledby="edit-bid-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm player-bid-modal" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="player-bid-modal-body">
                                                        <div class="player-bid-modal-content">
                                                            <div class="player-bid-modal-label">
                                                                <div class="custom-badge custom-badge-xl is-square is-gk">gk</div>
                                                            </div>
                                                            <div class="player-bid-modal-body">
                                                                <div class="player-bid-modal-title">H Lioris</div>
                                                                <div class="player-bid-modal-text">Tottenham</div>
                                                            </div>
                                                        </div>

                                                        <div class="my-3">
                                                            <button type="button" class="btn btn-primary btn-block">Edit bid</button>
                                                        </div>

                                                        <div class="row gutters-sm">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-tertiary btn-block">Remove bid</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="player-wrapper">
                                            <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>

                                            <div>
                                                <a href="#" class="team-name link-nostyle">Kepa</a>
                                                <br>
                                                <a href="#" class="player-name link-nostyle small">Chelsea</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">1.00</td>
                                    <td class="text-center">43</td>
                                    <td class="text-center">20</td>
                                    <td class="text-center">0</td>
                                    <td class="text-center">0</td>
                                    <td class="text-center">
                                        <div class="icon-plus"><a href="" class="text-secondary" data-toggle="modal" data-target="#bid-modal"><span><i class="far fa-plus-circle"></i></span></a></div>
                                    </td>

                                    <!-- Modal -->
                                    <div class="modal fade" id="bid-modal" tabindex="-1" role="dialog" aria-labelledby="bid-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm player-bid-modal" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="player-bid-modal-body">
                                                        <div class="player-bid-modal-content">
                                                            <div class="player-bid-modal-label">
                                                                <div class="custom-badge custom-badge-xl is-square is-fb">FB</div>
                                                            </div>
                                                            <div class="player-bid-modal-body">
                                                                <div class="player-bid-modal-title">Kepa</div>
                                                                <div class="player-bid-modal-text">Chelsea</div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="bid-amount">Enter bid amount (&euro;m)</label>
                                                            <input type="text" class="form-control" id="bid-amount" placeholder="e.g 15">
                                                        </div>

                                                        <div class="row gutters-sm">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-primary btn-block">Ok</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="player-wrapper">
                                            <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>
                                            <div>
                                                <a href="#" class="team-name link-nostyle">Allisson</a>
                                                <br>
                                                <a href="#" class="player-name link-nostyle small">Liverpool</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">1.50</td>
                                    <td class="text-center">4</td>
                                    <td class="text-center">13</td>
                                    <td class="text-center">2</td>
                                    <td class="text-center">-2</td>
                                    <td class="text-center">
                                        <div class="icon-plus"><a href="" class="text-secondary"><span><i class="far fa-plus-circle"></i></span></a></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4"></div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-uppercase">player</th>
                                    <th class="text-center text-uppercase">bid</th>
                                    <th class="text-center text-uppercase">pld</th>
                                    <th class="text-center text-uppercase">pts</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="is-success">
                                    <td>
                                        <div class="player-wrapper">
                                            <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                            <div>
                                                <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                <br>
                                                <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">17</td>
                                    <td class="text-center">19</td>
                                    <td class="text-center">
                                        <div class="won-player"><span class="bg-primary text-white py-1 px-2 text-uppercase">Won <i class="far fa-check"></i></span></div>
                                    </td>
                                </tr>

                                <tr class="is-disabled">
                                    <td>
                                        <div class="player-wrapper">
                                            <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                            <div>
                                                <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                <br>
                                                <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">17</td>
                                    <td class="text-center">19</td>
                                    <td class="text-center">
                                        <div class="quota-player"><span class="text-muted text-uppercase"><strong>quota</strong> <i class="fas fa-tshirt"></i></span></div>
                                    </td>
                                </tr>

                                <tr class="is-disabled">
                                    <td>
                                        <div class="player-wrapper">
                                            <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                            <div>
                                                <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                <br>
                                                <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">17</td>
                                    <td class="text-center">19</td>
                                    <td class="text-center">
                                        <div class="formation-validation d-flex justify-content-center align-items-center">
                                            <div class="text-uppercase"><strong>formation <br> validation</strong></div>
                                            <div class="position-relative">
                                                <span class="h5"><i class="fas fa-tshirt"></i></span>
                                                <span class="position-absolute text-danger player-state-indicator"><i class="fas fa-exclamation-circle"></i></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="is-disabled">
                                    <td>
                                        <div class="player-wrapper">
                                            <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                            <div>
                                                <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                <br>
                                                <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">17</td>
                                    <td class="text-center">19</td>
                                    <td class="text-center">
                                        <div class="text-muted text-uppercase won-by">
                                            <span><strong>won by</strong> <br> untappedtalent</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="container mt-4">
                    <h3>Player Statuses</h3>

                    <div class="row">
                        <div class="col-md-2">
                            <h6 class="text-center">Late fitness test</h6>
                            <div class="player-wrapper is-selected">
                                <div class="player-wrapper-img">
                                    <img src="../../public/assets/frontend/img/status/icon-team.svg" class="tshirt">
                                </div>
                                <div class="player-wrapper-body">
                                    <div class="player-wrapper-title">Valencia</div>
                                    <div class="player-wrapper-description">
                                        <div class="custom-badge custom-badge-lg is-square is-st">ST</div>
                                        <div class="player-wrapper-text">
                                            <div class="player-wrapper-status">
                                                <span>
                                                    <img src="../../public/assets/frontend/img/status/late.svg" class="status-img">
                                                </span>
                                            </div>
                                            <div class="player-wrapper-points"><span class="points">30</span> pts</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <h6 class="text-center">Doubtful</h6>
                            <a href="#" class="player-wrapper">
                                <div class="player-wrapper-img">
                                    <img src="../../public/assets/frontend/img/status/icon-team-2.svg" class="tshirt">
                                </div>
                                <div class="player-wrapper-body">
                                    <div class="player-wrapper-title">Luiz</div>
                                    <div class="player-wrapper-description">
                                        <div class="custom-badge custom-badge-lg is-square is-st">ST</div>
                                        <div class="player-wrapper-text">
                                            <div class="player-wrapper-status">
                                                <span>
                                                    <img src="../../public/assets/frontend/img/status/doubtful.svg" class="status-img">
                                                </span>
                                            </div>
                                            <div class="player-wrapper-points"><span class="points">31</span> pts</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2">
                            <h6 class="text-center">Injured</h6>
                            <div class="player-wrapper">
                                <div class="player-wrapper-img">
                                    <img src="../../public/assets/frontend/img/status/icon-team-3.svg" class="tshirt">
                                </div>
                                <div class="player-wrapper-body">
                                    <div class="player-wrapper-title">Alderweireld</div>
                                    <div class="player-wrapper-description">
                                        <div class="custom-badge custom-badge-lg is-square is-st">ST</div>
                                        <div class="player-wrapper-text">
                                            <div class="player-wrapper-status">
                                                <span>
                                                    <img src="../../public/assets/frontend/img/status/injured.svg" class="status-img">
                                                </span>
                                            </div>
                                            <div class="player-wrapper-points"><span class="points">31</span> pts</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <h6 class="text-center">International</h6>
                            <div class="player-wrapper">
                                <div class="player-wrapper-img">
                                    <img src="../../public/assets/frontend/img/status/icon-team-4.svg" class="tshirt">
                                </div>
                                <div class="player-wrapper-body">
                                    <div class="player-wrapper-title">Shaw</div>
                                    <div class="player-wrapper-description">
                                        <div class="custom-badge custom-badge-lg is-square is-st">ST</div>
                                        <div class="player-wrapper-text">
                                            <div class="player-wrapper-status">
                                                <span>
                                                    <img src="../../public/assets/frontend/img/status/international.svg" class="status-img">
                                                </span>
                                            </div>
                                            <div class="player-wrapper-points"><span class="points">31</span> pts</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <h6 class="text-center">Suspended</h6>
                            <div class="player-wrapper">
                                <div class="player-wrapper-img">
                                    <img src="../../public/assets/frontend/img/status/icon-team-5.svg" class="tshirt">
                                </div>
                                <div class="player-wrapper-body">
                                    <div class="player-wrapper-title">Richarlison</div>
                                    <div class="player-wrapper-description">
                                        <div class="custom-badge custom-badge-lg is-square is-st">ST</div>
                                        <div class="player-wrapper-text">
                                            <div class="player-wrapper-status">
                                                <span>
                                                    <img src="../../public/assets/frontend/img/status/suspension.svg" class="status-img">
                                                </span>
                                            </div>
                                            <div class="player-wrapper-points"><span class="points">31</span> pts</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <h6 class="text-center">Multiple</h6>
                            <div class="player-wrapper">
                                <div class="player-wrapper-img">
                                    <img src="../../public/assets/frontend/img/status/icon-team-6.svg" class="tshirt">
                                </div>
                                <div class="player-wrapper-body">
                                    <div class="player-wrapper-title">Richarlison</div>
                                    <div class="player-wrapper-description">
                                        <div class="custom-badge custom-badge-lg is-square is-st">ST</div>
                                        <div class="player-wrapper-text">
                                            <div class="player-wrapper-status">
                                                <span>
                                                    <img src="../../public/assets/frontend/img/status/suspension.svg" class="status-img">
                                                </span>
                                                <span>
                                                    <img src="../../public/assets/frontend/img/status/late.svg" class="status-img">
                                                </span>
                                            </div>
                                            <div class="player-wrapper-points"><span class="points">31</span> pts</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


        <div class="container-fluid pb-5">
            <h1>Table</h1>
            <div class="table-responsive">
                <table class="table text-center custom-table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">PLD</th>
                            <th scope="col" class="">GLS</th>
                            <th scope="col" class="association-badge">ASS</th>
                            <th scope="col">CS</th>
                            <th scope="col">GA</th>
                            <th scope="col">TOT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Home</th>
                            <td>5</td>
                            <td>1</td>
                            <td>0</td>
                            <td>0</td>
                            <td>8</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th scope="row">Away</th>
                            <td>6</td>
                            <td>0</td>
                            <td>2</td>
                            <td>1</td>
                            <td>12</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th scope="row">Total</th>
                            <td>11</td>
                            <td>1</td>
                            <td>2</td>
                            <td>1</td>
                            <td>20</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Brand color  -->
            <div class="container-fluid example-container mt-5" data-category="brand-color">
                <h1>Brand color</h1>
                <div class="mt-3 mb-5">
                    <h3>Theme colors</h3>
                    <div class="p-2 mb-2 bg-primary text-white">.bg-primary</div>
                    <div class="p-2 mb-2 bg-secondary text-white">.bg-secondary</div>
                    <div class="p-2 mb-2 bg-tertiary text-white">.bg-tertiary</div>
                    {{-- <div class="p-2 mb-2 bg-success text-white">.bg-success</div> --}}
                    {{-- <div class="p-2 mb-2 bg-danger text-white">.bg-danger</div> --}}
                    {{-- <div class="p-2 mb-2 bg-warning text-white">.bg-warning</div> --}}
                    {{-- <div class="p-2 mb-2 bg-info text-white">.bg-info</div> --}}
                    <div class="p-2 mb-2 bg-light">.bg-light</div>
                    <div class="p-2 mb-2 bg-dark text-white">.bg-dark</div>
                    <div class="p-2 mb-2 bg-brown-pod text-white">.bg-brown-pod</div>
                    <div class="p-2 mb-2 bg-white text-white">.bg-white</div>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Gradient of grey</h3>
                    <div class="p-2 mb-2 swatch-100">.swatch-100</div>
                    <div class="p-2 mb-2 swatch-200">.swatch-200</div>
                    <div class="p-2 mb-2 swatch-300">.swatch-300</div>
                    <div class="p-2 mb-2 swatch-400">.swatch-400</div>
                    <div class="p-2 mb-2 swatch-500">.swatch-500</div>
                    <div class="p-2 mb-2 swatch-600">.swatch-600</div>
                    <div class="p-2 mb-2 swatch-700">.swatch-700</div>
                    <div class="p-2 mb-2 swatch-800">.swatch-800</div>
                    <div class="p-2 mb-2 swatch-900">.swatch-900</div>
                </div>
            </div>
            <!-- Links  -->
            <div class="container-fluid example-container" data-category="links">
                <h1>Links</h1>
                <div class="mt-3 mb-5">
                    <h3>Default Link</h3>
                    <a href="javascript:void(0);">Exemple link</a>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Link inside an alert</h3>
                    <div class="alert alert-primary" role="alert">
                        This is a primary alert with
                        <a href="javascript:void(0);" class="alert-link">an example link</a>. Give it a click if you like.
                    </div>
                </div>
            </div>
            <!-- Grid  -->
            <div class="container-fluid example-container" data-category="grid">
                <h1>Grid</h1>
                <div>
                    <div class="bs-example-row">
                        <!-- Bootstrap Grid -->
                        <div class="row">
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                            <div class="col-sm-1">.col-sm-1</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">.col-sm-2</div>
                            <div class="col-sm-3">.col-sm-3</div>
                            <div class="col-sm-7">.col-sm-7</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">.col-sm-4</div>
                            <div class="col-sm-4">.col-sm-4</div>
                            <div class="col-sm-4">.col-sm-4</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">.col-sm-5</div>
                            <div class="col-sm-7">.col-sm-7</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">.col-sm-6</div>
                            <div class="col-sm-6">.col-sm-6</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">.col-sm-12</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fonts  -->
            <div class="container-fluid example-container" data-category="fonts">
                <h1>Fonts</h1>
                <div>
                    <h1>h1 </h1>
                    <h2>h2 </h2>
                    <h3>h3 </h3>
                    <h4>h4 </h4>
                    <h5>h5 </h5>
                    <h6>h6 </h6>
                    <br>
                    <h1>Heading 1
                        <small>Sub-heading</small>
                    </h1>
                    <h2>Heading 2
                        <small>Sub-heading</small>
                    </h2>
                    <h3>Heading 3
                        <small>Sub-heading</small>
                    </h3>
                    <h4>Heading 4
                        <small>Sub-heading</small>
                    </h4>
                    <h5>Heading 5
                        <small>Sub-heading</small>
                    </h5>
                    <h6>Heading 6
                        <small>Sub-heading</small>
                    </h6>
                    <br>
                    <h1 class="display-1">Display 1</h1>
                    <h1 class="display-2">Display 2</h1>
                    <h1 class="display-3">Display 3</h1>
                    <h1 class="display-4">Display 4</h1>
                    <br>
                    <p class="lead">
                        This is the article lead — it stands out at the start of the article.
                    </p>
                    <p>
                        This is normal text at the normal size etc...
                    </p>
                    <p>Sample
                        <mark>marked text</mark>.
                    </p>
                    <br>
                    <blockquote class="blockquote">
                        <p>The most important moment of your life is now. The most important person in your life is the one you are with now,
                            and the most important activity in your life is the one you are involved with now.
                        </p>
                    </blockquote>
                </div>
            </div>
            <!-- Buttons  -->
            <div class="container-fluid example-container" data-category="buttons">
                <h1>Buttons</h1>
                <div class="mt-3 mb-5">
                    <h3>Default buttons</h3>
                    <button type="button" class="btn btn-primary">Primary</button>
                    <button type="button" class="btn btn-secondary">Secondary</button>
                    <button type="button" class="btn btn-tertiary">Tertiary</button>
                    {{-- <button type="button" class="btn btn-info">Info</button> --}}
                    {{-- <button type="button" class="btn btn-success">Success</button> --}}
                    {{-- <button type="button" class="btn btn-warning">Warning</button> --}}
                    {{-- <button type="button" class="btn btn-danger">Danger</button> --}}
                    <button type="button" class="btn btn-light">Light</button>
                    <button type="button" class="btn btn-dark">Dark</button>
                    <button type="button" class="btn btn-brown-pod">Brown-pod</button>
                    <button type="button" class="btn btn-link">Link</button>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Buttons with outline</h3>
                    <button type="button" class="btn btn-outline-primary">Primary</button>
                    <button type="button" class="btn btn-outline-secondary">Secondary</button>
                    <button type="button" class="btn btn-outline-tertiary">Tertiary</button>
                    {{-- <button type="button" class="btn btn-outline-info">Info</button> --}}
                    {{-- <button type="button" class="btn btn-outline-success">Success</button> --}}
                    {{-- <button type="button" class="btn btn-outline-warning">Warning</button> --}}
                    {{-- <button type="button" class="btn btn-outline-danger">Danger</button> --}}
                    <button type="button" class="btn btn-outline-light">Light</button>
                    <button type="button" class="btn btn-outline-dark">Dark</button>
                    <button type="button" class="btn btn-outline-brown-pod">Brown-pod</button>
                    <button type="button" class="btn btn-outline-link">Link</button>
                    <span class="bg-primary p-4">
                        <button type="button" class="btn btn-outline-white">White</button>
                    </span>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Buttons with icons</h3>
                    <button type="button" class="btn btn-primary has-icon">
                        <i class="fas fa-star"></i>Primary
                    </button>
                    <button type="button" class="btn btn-secondary has-icon">
                        <i class="fas fa-star"></i>Secondary
                    </button>
                    <button type="button" class="btn btn-tertiary has-icon">
                        <i class="fas fa-star"></i>Tertiary
                    </button>
                    {{-- <button type="button" class="btn btn-info has-icon">
                        <i class="fas fa-star"></i>Info
                    </button> --}}
                    {{-- <button type="button" class="btn btn-success has-icon">
                        <i class="fas fa-star"></i>Success
                    </button> --}}
                    {{-- <button type="button" class="btn btn-warning has-icon">
                        <i class="fas fa-star"></i>Warning
                    </button> --}}
                    {{-- <button type="button" class="btn btn-danger has-icon">
                        <i class="fas fa-star"></i>Danger
                    </button> --}}
                    <button type="button" class="btn btn-light has-icon">
                        <i class="fas fa-star"></i>Light
                    </button>
                    <button type="button" class="btn btn-dark has-icon">
                        <i class="fas fa-star"></i>Dark
                    </button>
                    <button type="button" class="btn btn-brown-pod has-icon">
                        <i class="fas fa-star"></i>Brown-pod
                    </button>
                    <button type="button" class="btn btn-link has-icon">
                        <i class="fas fa-star"></i>Link
                    </button>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Buttons sizes</h3>
                    <button type="button" class="btn btn-success btn-sm">Small</button>
                    <button type="button" class="btn btn-success">Default</button>
                    <button type="button" class="btn btn-success btn-lg">Large</button>
                    <br>
                    <button type="button" class="btn btn-danger btn-lg btn-block">Block level button</button>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Disabled button</h3>
                    <p>
                        <a href="javascript:void(0);" class="btn btn-primary btn-lg disabled" role="button">The 'a' Element</a>
                    </p>
                    <p>
                        <button type="button" class="btn btn-lg btn-primary" disabled="disabled">The 'button' Element</button>
                    </p>
                    <p>
                        <input type="button" class="btn btn-lg btn-primary" disabled="disabled" value="The 'input' Element">
                    </p>
                </div>
            </div>
            <!-- Forms  -->
            <div class="container-fluid example-container" data-category="forms">
                <h1>Forms</h1>
                <div class="mt-3 mb-5">
                    <h3>Default form group</h3>
                    <form action="javascript:void(0);">
                        <fieldset class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </fieldset>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
                <h3>Inline form</h3>
                <div class="mt-3 mb-5">
                    <form action="javascript:void(0);" class="form-inline">
                        <label class="mr-sm-2 mb-0" for="first_name">First Name</label>
                        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="first_name" name="first_name">
                        <label class="mr-sm-2 mb-0" for="last_name">Last Name</label>
                        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="last_name" name="last_name">
                        <button type="submit" class="btn btn-default mt-2 mt-sm-0">Submit</button>
                    </form>
                </div>
                <h3>Aligned form</h3>
                <div class="mt-3 mb-5">
                    <div class="container">
                        <form action="javascript:void(0);">
                            <div class="form-group row">
                                <label for="first_name" class="col-xs-3 col-form-label mr-2">First Name</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" id="first_name" name="first_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="col-xs-3 col-form-label mr-2">Last Name</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" id="last_name" name="last_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-xs-3 col-xs-9">
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div>
                    <div class="container">
                        <form action="javascript:void(0);">
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-legend col-3">Fruit</legend>
                                    <div class="col-9">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="legendRadio1" name="legendRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="legendRadio1">Apple</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="legendRadio2" name="legendRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="legendRadio2">Orange</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="legendRadio3" name="legendRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="legendRadio3">Watermalon</label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row">
                                <label for="first_name" class="col-3 col-form-label">First Name</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="first_name" name="first_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="col-3 col-form-label">Last Name</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="last_name" name="last_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-3 col-9">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <h3>Form with help text </h3>
                <div class="mt-3 mb-5">
                    <label for="accountId">Account Id</label>
                    <input type="text" id="accountId" class="form-control" aria-describedby="helpAccountId">
                    <span id="helpAccountId" class="form-text text-muted">Your account ID is located at the top of your invoice.</span>
                </div>
                <h3>Checkbox and radio </h3>
                <div class="mt-3 mb-5">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Check this custom checkbox</label>
                    </div>
                </div>
                <div class="mt-3 mb-5">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio1">Toggle this custom radio</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio2">Or toggle this other custom radio</label>
                    </div>
                </div>
                <div class="mt-3 mb-5">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                        <label class="custom-control-label" for="customRadioInline1">Toggle this custom radio</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                        <label class="custom-control-label" for="customRadioInline2">Or toggle this other custom radio</label>
                    </div>
                </div>
                <div class="mt-3 mb-5">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheckDisabled1" disabled>
                        <label class="custom-control-label" for="customCheckDisabled1">Check this custom checkbox</label>
                    </div>

                    <div class="custom-control custom-radio">
                        <input type="radio" name="radioDisabled" id="customRadioDisabled2" class="custom-control-input" disabled>
                        <label class="custom-control-label" for="customRadioDisabled2">Toggle this custom radio</label>
                    </div>
                </div>
            </div>
            <!-- Tables  -->
            <div class="container-fluid example-container" data-category="tables">
                <h1>Tables</h1>
                <div class="mt-3 mb-5">
                    <h3>Default table</h3>
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Header 1</th>
                                    <th>Header 2</th>
                                    <th>Header 3</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Footer 1</th>
                                    <th>Footer 2</th>
                                    <th>Footer 3</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td>Cell</td>
                                    <td>Cell</td>
                                    <td>Cell</td>
                                </tr>
                                <tr>
                                    <td>Cell</td>
                                    <td>Cell</td>
                                    <td>Cell</td>
                                </tr>
                                <tr>
                                    <td>Cell</td>
                                    <td>Cell</td>
                                    <td>Cell</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Table inverse</h3>
                    <table class="table table-inverse">
                        <thead>
                            <tr>
                                <th>Header 1</th>
                                <th>Header 2</th>
                                <th>Header 3</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Footer 1</th>
                                <th>Footer 2</th>
                                <th>Footer 3</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Table striped</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Header 1</th>
                                <th>Header 2</th>
                                <th>Header 3</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Footer 1</th>
                                <th>Footer 2</th>
                                <th>Footer 3</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Table with border</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Header 1</th>
                                <th>Header 2</th>
                                <th>Header 3</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Footer 1</th>
                                <th>Footer 2</th>
                                <th>Footer 3</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Table with hover</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Header 1</th>
                                <th>Header 2</th>
                                <th>Header 3</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Footer 1</th>
                                <th>Footer 2</th>
                                <th>Footer 3</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Table with Head with default color</h3>
                    <table class="table">
                        <thead class="thead-default">
                            <tr>
                                <th>Header 1</th>
                                <th>Header 2</th>
                                <th>Header 3</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Footer 1</th>
                                <th>Footer 2</th>
                                <th>Footer 3</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Table with inverse Head color</h3>
                    <table class="table">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Header 1</th>
                                <th>Header 2</th>
                                <th>Header 3</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Footer 1</th>
                                <th>Footer 2</th>
                                <th>Footer 3</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                            <tr>
                                <td>Cell</td>
                                <td>Cell</td>
                                <td>Cell</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Tabs -->
            <ul class="nav nav-pills nav-justified border border-secondary mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">...</div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
            </div>
            <!-- Tabs -->
            <!-- Alerts  -->
            <div class="container-fluid example-container" data-category="alerts">
                <h1>Alerts</h1>
                <div class="mt-3 mb-5">
                    <h3>Default alert</h3>
                    <div class="alert alert-secondary" role="alert">Secondary alert</div>
                    <div class="alert alert-success" role="alert">Success alert</div>
                    <div class="alert alert-warning" role="alert">Warning alert</div>
                    <div class="alert alert-danger" role="alert">Danger alert</div>
                    <div class="alert alert-light" role="alert">Light alert</div>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Dismissible alert</h3>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        <strong>Congratulations!</strong> You successfully tied your shoelace!
                    </div>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Dismissible alert with fade</h3>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        <strong>Congratulations!</strong> You successfully tied your shoelace!
                    </div>
                </div>
            </div>
            <!-- List group  -->
            <div class="container-fluid example-container" data-category="list-group">
                <h1>List group</h1>
                <div class="mt-3 mb-5">
                    <h3>Default list group</h3>
                    <ul class="list-group">
                        <li class="list-group-item">These Boots Are Made For Walking</li>
                        <li class="list-group-item">Eleanor, Put Your Boots On</li>
                        <li class="list-group-item">Puss 'n' Boots</li>
                        <li class="list-group-item">Die With Your Boots On</li>
                        <li class="list-group-item">Fairies Wear Boots</li>
                    </ul>
                </div>
                <div class="mt-3 mb-5">
                    <h3>List group with pills</h3>
                    <ul class="list-group">
                        <li class="list-group-item justify-content-between">
                            These Boots Are Made For Walking
                            <span class="badge badge-secondary badge-pill">15</span>
                        </li>
                        <li class="list-group-item justify-content-between">
                            Eleanor, Put Your Boots On
                            <span class="badge badge-secondary badge-pill">38</span>
                        </li>
                        <li class="list-group-item justify-content-between">
                            Puss 'n' Boots
                            <span class="badge badge-secondary badge-pill">76</span>
                        </li>
                        <li class="list-group-item justify-content-between">
                            Die With Your Boots On
                            <span class="badge badge-secondary badge-pill">112</span>
                        </li>
                        <li class="list-group-item justify-content-between">
                            Fairies Wear Boots
                            <span class="badge badge-secondary badge-pill">181</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Link List group</h3>
                    <div class="list-group">
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action">These Boots Are Made For Walking</a>
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action active">Eleanor, Put Your Boots On</a>
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action">Puss 'n' Boots</a>
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action">Die With Your Boots On</a>
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action">Fairies Wear Boots</a>
                    </div>
                </div>
                <div class="mt-3 mb-5">
                    <h3>Button List group</h3>
                    <div class="list-group">
                        <button type="button" class="list-group-item list-group-item-action">These Boots Are Made For Walking</button>
                        <button type="button" class="list-group-item list-group-item-action active">Eleanor, Put Your Boots On</button>
                        <button type="button" class="list-group-item list-group-item-action">Puss 'n' Boots</button>
                        <button type="button" class="list-group-item list-group-item-action">Die With Your Boots On</button>
                        <button type="button" class="list-group-item list-group-item-action">Fairies Wear Boots</button>
                    </div>
                </div>
                <div class="mt-3 mb-5">
                    <h3>List group with colors</h3>
                    <div class="list-group">
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action list-group-item-success">These Boots Are Made For Walking</a>
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action list-group-item-success active">Eleanor, Put Your Boots On</a>
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action list-group-item-warning">Die With Your Boots On</a>
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action list-group-item-danger">Fairies Wear Boots</a>
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action list-group-item-light">Head Over Boots</a>
                    </div>
                </div>
            </div>
            <!-- Image thumbnails  -->
            <div class="container-fluid example-container" data-category="image-thumbnails">
                <h1>Image thumbnails </h1>
                <div>
                    <img src="https://via.placeholder.com/100x100" class="rounded" alt="Sample image">
                    <img src="https://via.placeholder.com/100x100" class="rounded-circle" alt="Sample image">
                    <img src="https://via.placeholder.com/100x100" class="img-thumbnail" alt="Sample image">
                    <img src="https://via.placeholder.com/100x100" class="rounded-top" alt="Sample image">
                </div>
            </div>
            <!-- Close  -->
            <div class="container-fluid example-container" data-category="close">
                <h1>Close</h1>
                <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>

            {{-- Players --}}
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ars_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ars_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ars_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ars_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ast_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ast_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ast_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ast_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bou_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bou_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bou_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bou_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bha_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bha_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bha_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bha_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bur_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bur_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bur_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img bur_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img car_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img car_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img car_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img car_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img che_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img che_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img che_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img che_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img cp_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img cp_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img cp_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img cp_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img eve_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img eve_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img eve_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img eve_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ful_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ful_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ful_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img ful_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img hud_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img hud_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img hud_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img hud_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img lei_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img lei_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img lei_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img lei_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img liv_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img liv_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img liv_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img liv_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img mc_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img mc_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img mc_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img mc_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img mu_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img mu_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img mu_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img mu_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img new_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img new_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img new_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img new_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img nor_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img nor_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img nor_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img nor_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img shu_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img shu_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img shu_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img shu_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img sot_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img sot_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img sot_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img sot_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img tot_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img tot_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img tot_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img tot_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wat_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wat_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wat_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wat_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wh_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wh_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wh_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wh_player-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wol_gk"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wol_gk-selected"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wol_player"></div>
                        </div>
                        <div class="player-wrapper">
                            <div class="player-wrapper-img wol_player-selected"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script src="{{ asset('assets/frontend/js/app.js')}}"></script>
        <script src="{{ asset('assets/frontend/js/plugins/all.js')}}"></script>
        {{-- <script type="text/javascript">
            jQuery(document).ready(function() {
                $('.form-wizard fieldset:first').fadeIn('slow');
                $('.form-wizard .btn-next').on('click', function() {
                    var parent_fieldset = $(this).parents('fieldset');
                    var current_active_step = $(this).parents('.form-wizard').find('.active');
                    parent_fieldset.fadeOut(400, function() {
                        current_active_step.removeClass('active').addClass('activated').next().addClass('active');
                        $(this).next().fadeIn();
                    });
                });

                $('.form-wizard .btn-previous').on('click', function() {
                    var current_active_step = $(this).parents('.form-wizard').find('.active');
                    $(this).parents('fieldset').fadeOut(400, function() {
                        current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
                        $(this).prev().fadeIn();
                    });
                });
            });
        </script> --}}

        {{-- <script type="text/javascript">
            (function($) {
                'use strict';

                $(function() {

                    $(document).ready(function() {
                        function triggerClick(elem) {
                            $(elem).click();
                        }
                        var $progressWizard = $('.stepper'),
                            $tab_active,
                            $tab_prev,
                            $tab_next,
                            $btn_prev = $progressWizard.find('.prev-step'),
                            $btn_next = $progressWizard.find('.next-step'),
                            $tab_toggle = $progressWizard.find('[data-toggle="tab"]'),
                            $tooltips = $progressWizard.find('[data-toggle="tab"][title]');


                        //Wizard
                        $tab_toggle.on('show.bs.tab', function(e) {
                            var $target = $(e.target);

                            if (!$target.parent().hasClass('active, disabled')) {
                                $target.parent().prev().addClass('completed');
                                $target.parent().prev().removeClass('active');
                            }
                            if ($target.parent().hasClass('disabled')) {
                                return false;
                            }
                        });
                        $btn_next.on('click', function() {
                            $tab_active = $progressWizard.find('.active');

                            $tab_active.next().removeClass('disabled');
                            $tab_active.next().addClass('active');

                            $tab_next = $tab_active.next().find('a[data-toggle="tab"]');
                            triggerClick($tab_next);

                        });
                        $btn_prev.click(function() {
                            $tab_active = $progressWizard.find('.active');
                            $tab_prev = $tab_active.prev().find('a[data-toggle="tab"]');
                            triggerClick($tab_prev);
                        });
                    });
                });

            }(jQuery, this));
        </script> --}}
    </body>
</html>
