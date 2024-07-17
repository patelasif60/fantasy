<!DOCTYPE html>
<html>
    <head>
        <title>Password protected</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Roboto', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 36px;
            }

            .form-control {
                border: 1px solid #ccc;
                padding: 10px 20px;
            }

            .hidden {
                display: none;
            }

            .text-danger {
                color: #d9534f;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content col-xs-10 col-sm-10 col-md-6 col-lg-6 col-xl-4 justify-content-center">

                <div class="card">
                    <div class="card-body">
                        <form class="text-center" method="GET">

                            {{ csrf_field() }}

                            <h5 class="bd-title" id="content">This site is password protected</h5>

                            <input type="password" name="site-password-protected" placeholder="Enter password" class="form-control mt-4" tabindex="1" autofocus />

                            @if (Request::get('site-password-protected'))
                                <div class="text-danger">Password is wrong</div>
                            @endif

                            <!-- Sign in button -->
                            <button class="btn btn-info btn-block mt-4" type="submit">Confirm</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
