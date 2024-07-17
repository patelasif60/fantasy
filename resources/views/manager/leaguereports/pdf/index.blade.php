<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 
        <title>Laravel</title>
        <style type="text/css" media="print">
                table.report-table {
                    margin-top: 30px;
                    padding-bottom: 30px;
                    text-align: left;
                    width: 100%;
                    height: auto;
                    border-collapse: collapse;
                    border: 2px solid #000;
                    font: 15px Arial, sans-serif;
                }

                table.player-table {
                    margin: 30px 10px;
                    text-align: left;
                    float: left;
                    width: 31%;
                    height: 50%;
                    border-collapse:collapse;
                    border:2px solid #000;
                    font: 15px Arial, sans-serif;
                }

                table.position-table {
                    margin: 30px 10px;
                    text-align: left;
                    float: left;
                    width: 45%;
                    height: auto;
                    border-collapse: collapse;
                    border: 2px solid #000;
                    font: 15px Arial, sans-serif;
                }

                .team-title {
                    padding-bottom: 20px;
                }

                .sub-page {
                    page-break-before: always;
                    margin-top: 30px;
                }

                tr {
                     border: 2px solid #000;
                }

                th, .title {
                    color: #bdbdbd;
                    font: bold 15px Arial, sans-serif;
                }

                .div-name {
                    margin-top: 20px;
                }

                caption {
                    text-align: left;
                }

                .page-break, .header {
                    page-break-before: always;
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
            <div class = "row">
                {!! html_entity_decode($page) !!}
                
            </div>
            @endforeach
        </div>
    </body>
</html>