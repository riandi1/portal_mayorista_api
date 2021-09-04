<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Platform Mailer</title>
    <style>
        .mail-header{

        }
        .mail-content{

        }
        .mail-footer{

        }
    </style>
</head>
<body>
<header class="mail-header">
    <h2>Platform</h2>
    @isset($title)
        <br/>
        <h4>{{$title}}</h4>
    @endif
</header>
<main class="mail-content">
    @yield('mail-content')
</main>
<footer>

</footer>
</body>
</html>
