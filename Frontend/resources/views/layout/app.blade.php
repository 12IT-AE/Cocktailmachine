<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DrinkPad '24</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(180deg, #171717 0%, #3A1010 100%);
            color: white;
        }
        .card {
            background-color: #3d3d3d;
            border: none;
        }
        .card-title {
            font-family: "Jaini Purva";
            font-size: 48px;
            font-weight: 400;
            line-height: 63.07px;
            text-align: center;

        }
        .btn-produce {
            background-color: #800000;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        @yield('content')
    </div>
</body>
</html>
