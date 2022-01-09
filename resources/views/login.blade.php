<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smp Annahl</title>
    <link rel="stylesheet" href="{{ asset('storage//voler/assets/css/bootstrap.css') }}">

    <link rel="shortcut icon" href="{{ asset('storage/img/core/annahl.png') }}" type="image/x-icon">
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
                                <img src="{{ asset('storage/img/core/annahl.png') }}" height="90" class='mb-4'>
                                <h3>Sign In</h3>
                                <p>Please sign in to continue to Annahl.</p>
                            </div>

                            @error('fail')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <form action="/login" method="POST">
                                @csrf
                                <div class="form-group position-relative has-icon-left">
                                    <label for="username">Username</label>
                                    <div class="position-relative">
                                        <input type="text" name="username" class="form-control" id="username" required autofocus>
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <label for="password">Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password" class="form-control" id="password" required>
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class='form-check clearfix my-4'>
                                    <div class="checkbox float-start">
                                        <input type="checkbox" id="checkbox1" class='form-check-input'>
                                        <label for="checkbox1">Remember me</label>
                                    </div>
                                </div> --}}
                                <div class="clearfix">
                                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                                </div>
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
</body>

</html>
