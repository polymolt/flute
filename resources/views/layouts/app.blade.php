<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.11/semantic.min.css">
    </head>

    <body style="background: #f0f0f0">
            <div class="ui card" style="position: relative; width:300px; margin:0 auto; top: 20%;">
                @yield('box-content')
                <div class="extra content">
                    <i>@yield('box-info')</i>
                </div>
            </div>
    </body>
</html>