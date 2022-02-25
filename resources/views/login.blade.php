<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ school()->name }}</title>
    <link rel="stylesheet" href="{{ asset('storage//voler/assets/css/bootstrap.css') }}">

    <link rel="shortcut icon" href="{{ school()->logo }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('storage//voler/assets/css/app.css') }}">
</head>

<body>
    <div id="auth">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="{{ school()->logo }}" height="90" class='mb-4'>
                                <h3>Sign In</h3>
                                <p>Please sign in to continue</p>
                            </div>

                            @if($alert = session('alert'))
                            <x-alert :type="$alert['type']" :message="$alert['message']" />
                            @endif

                            <form action="/login" method="POST">
                                @csrf
                                <div class="form-group position-relative has-icon-left">
                                    <label for="username">Username</label>
                                    <div class="position-relative">
                                        <input type="text" name="username" class="form-control" id="username" required
                                            autofocus>
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <label for="password">Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password" class="form-control" id="password"
                                            required>
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class='form-check clearfix my-2'>
                                    <div class="checkbox float-start">
                                        <input type="checkbox" name="remember" id="checkbox1" value="1"
                                            class='form-check-input'>
                                        <label for="checkbox1">Remember me</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('storage/voler/assets/js/feather-icons.js') }}"></script>
    <script src="{{ asset('storage/voler/assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('storage/voler/assets/js/app.js') }}"></script>
    <script src="{{ asset('storage/voler/assets/js/main.js') }}"></script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>