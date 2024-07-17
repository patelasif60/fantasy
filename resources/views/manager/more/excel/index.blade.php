<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 
        <title>{{ config('app.name') }}</title>
        <style type="text/css" media="print">
                table.position-table {
                    margin: 30px 10px;
                    text-align: left;
                    float: left;
                    width: auto;
                    height: auto;
                    border-collapse: collapse;
                    border: 2px solid #000;
                    font: 15px Arial, sans-serif;
                }

                .container {
                    float: none
                }
        </style>

    </head>
    <body>
        <div class="container">
            @foreach($pages as $page)
            {!! html_entity_decode($header) !!}
            {!! html_entity_decode($page) !!}
            @endforeach
        </div>
    </body>
</html>