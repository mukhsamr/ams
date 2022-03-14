<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ school()->logo }}" type="image/x-icon">

    <title>{{ school()->name }}</title>
    @include('layout.style')
</head>

<body>
    <div id="app">

        @include('layout.sidebar')

        <div id="main">

            @include('layout.topbar')

            <div class="main-content container-fluid">
                @yield('content')
            </div>

            @include('layout.footer')
        </div>
    </div>

    @include('layout.script')

</body>

</html>