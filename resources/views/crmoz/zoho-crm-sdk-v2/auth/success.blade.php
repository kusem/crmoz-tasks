<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="are-token" content="{{config('are.ext.areToken')}}">

    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,800,900|Material+Icons' rel="stylesheet">

    <title>Zoho oAuth Success</title>

    <style>
        body{
            height: 100vh;
            font-family: Roboto, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgb(0, 145, 7);
            overflow: hidden;
            color: #fff;
        }

        i{
            font-size: 100px !important;
            margin: 10px auto 0;
            color: #fff;
            justify-content: center;
        }

        a{
            padding: 5px 10px;
            background: #fff;
            color: rgb(0, 145, 7);
            border-radius: 2px;
        }

    </style>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300' rel="stylesheet">
</head>
    <body>
        <i class="material-icons">success</i>
        <h2>Auth procedure completed.</h2>
    </body>
</html>
