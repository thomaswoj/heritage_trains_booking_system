<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
        }

        .container {
            text-align: center;
        }

        h1 {
            padding-top: 120px;
            text-transform: uppercase;
        }

        @page { size: 500px 500px;  }
    </style>
</head>
<body>

{{--<h1>Base PDF Template</h1>--}}

<div class="container">
    <h1>Train Ticket</h1>
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->color(169,221,214)->size(200)->generate('Make me into an QrCode!')) !!} ">
</div>


</body>
</html>