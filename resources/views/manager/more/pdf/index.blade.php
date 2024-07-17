<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 
        <title>{{ config('app.name') }}</title>
        <style type="text/css" media="print">
            table {
                font: 8px Arial, sans-serif;
                border-collapse: collapse;
                border: none;
                width: 31%;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            th, tr, td {
                border: none;
            }
            table.report-table {
                margin-top: 30px;
                padding-bottom: 30px;
                text-align: left;
                /*width: 100%;*/
                height: auto;
            }

            table.player-table {
                margin: 30px 10px;
                text-align: left;
                float: left;
                /*width: 31%;*/
                height: 50%;
            }

            table.position-table {
                margin: 30px 10px;
                text-align: left;
                float: left;
                /*width: 45%;*/
            }

            .team-title {
                padding-bottom: 20px;
            }

            .sub-page {
                page-break-before: always;
                margin-top: 30px;
            }
            

            th, .title {
                color: #bdbdbd;
                font: bold 8px Arial, sans-serif;
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

            thead{display: table-header-group;}
            tfoot {display: table-row-group;}
            tr {page-break-inside: avoid;}

        </style>

    </head>
    <body style="margin:0; padding:0;">
        <div class="container" style="margin-top: 100px;">
            @foreach($pages as $page)
            {!! html_entity_decode($header) !!}
            <div class="row">
                {!! html_entity_decode($page) !!}
            </div>
            @endforeach
        </div>
    </body>
</html>