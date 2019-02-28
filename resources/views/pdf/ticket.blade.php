<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <style type="text/css">
        @page {
            margin: 0;
        }
        body {
            margin: 0px;
        }
        * {
            /*margin: 0;*/
            font-family: Verdana, Arial, sans-serif;
        }
        .container {
            margin: 20px 20px 0 20px;
            height: 350px;
            width: 508px;
            border: solid 1px black;
            border-radius: 5px;

            /*position: relative;*/
        }

        .train-img {
            margin-top: 100px;
            height: 200px;
        }

        .col-left {
            text-align: left;
            width: 200px;
            position: absolute;
        }
        .col-right {
            text-align: right;
            width: 200px;
            position: absolute;
        }
        .text {
            padding: 3px;
            text-transform: uppercase;
        }
        .bold {
            font-weight: bold;
        }
        .qr-code {
            position: absolute;
            top: 198px;
            right: 46px;
            border: 3px solid white;
            border-radius: 2px;
        }

        .page-break {
            page-break-after: always;
        }

    </style>
</head>
<body>

@php($current_ticket_count = 1)

@foreach($tickets as $ticket)
    @include('pdf.partials.ticket', ['ticket' => $ticket])
    @if($current_ticket_count !== $tickets->count())
        <div class="page-break"></div>
    @endif
    @php($current_ticket_count++)
@endforeach

</body>
</html>