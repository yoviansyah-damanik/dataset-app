<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="nofollow" />
    <meta name="googlebot" content="noindex" />
    <meta name="og:image" content="{{ GeneralHelper::get_ads() }}" />
    <meta name="og:description"
        content="{{ GeneralHelper::get_app_name() . ' (' . GeneralHelper::get_abb_app_name() . ') - ' . GeneralHelper::get_unit_name() }}" />
    <title>{{ GeneralHelper::get_abb_app_name() . ' | ' . GeneralHelper::get_unit_name() }}</title>
    <link rel="icon" type="image/x-icon" href="{{ GeneralHelper::get_favicon() }}">
    <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body class="login-background" style="background-image: url('{{ GeneralHelper::get_login_background() }}')">
    <div class="login-overlay">
        <div class="login-form">
            <div class="form">
                <div class="logo">
                    <img src="{{ GeneralHelper::get_app_logo() }}" alt="Logo">
                </div>
                <div class="title">
                    Masuk
                </div>
                <div class="subtitle">
                    Silahkan masuk terlebih dahulu.
                </div>

                @if (session('msg'))
                    <div class="alert alert-warning fade show" role="alert">
                        {{ session('msg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login.do') }}" method="post">
                    @csrf
                    <div class="form-group mb-3 position-relative">
                        <label for="username">Username/Email</label>
                        <input type="text" class="form-control" name="username" id="username"
                            value="{{ old('username') }}" placeholder="Masukkan username/email..." autofocus
                            autocomplete="off" required>
                    </div>
                    <div class="form-group mb-3 position-relative">
                        <label for="password">Kata Sandi</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Masukkan kata sandi..." required>
                    </div>
                    <button type="submit" class="btn w-100 mt-3">
                        <i class="fas fa-sign-in"></i>
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>
