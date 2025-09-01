<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | RSS Security Service-Admin</title>
    <!--font-awesome-css-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">
    <!-- tabler icons-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/tabler-icons/tabler-icons.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body class="sign-in-bg">
    <div class="app-wrapper d-block">
        <div class="main-container">
            <div class="container">
                <div class="row sign-in-content-bg">

                    <!-- Left Image Section -->
                    <div class="col-lg-6 image-contentbox d-none d-lg-block">
                        <div class="form-container">
                            <div class="signup-content mt-4">
                                <span>
                                    <img src="{{ asset('assets/images/logo/RSS_Security_Logo.png') }}" alt="Logo"
                                        class="img-fluid" style="width: 350px;">
                                </span>
                            </div>
                            <div class="signup-bg-img">
                                <img src="{{ asset('assets/images/login/security-img.jpg') }}" alt="Login"
                                    class="img-fluid p-5">
                            </div>
                        </div>
                    </div>

                    <!-- Login Form Section -->
                    <div class="col-lg-6 form-contentbox">
                        <div class="form-container">
                            <form method="POST" action="{{ route('login') }}" class="app-form">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-5 text-center text-lg-start">
                                            <h2 class="text-primary f-w-600" style="pointer-events: none">Welcome To <i class="text-danger">RSS
                                                Security Service!</i></h2>
                                            {{-- <p>Sign in with your data that you enterd during your registration</p> --}}
                                        </div>
                                    </div>


                                    <!-- Laravel Session Status -->
                                    @if (session('status'))
                                        <div class="alert alert-success">{{ session('status') }}</div>
                                    @endif



                                    <!-- Email -->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Username</label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autofocus autocomplete="username"
                                                placeholder="Enter Your Username">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}"
                                                    class="link-primary float-end">Forgot Password ?</a>
                                            @endif
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password"
                                                placeholder="Enter Your Password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="col-12">
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="remember_me"
                                                name="remember">
                                            <label class="form-check-label" for="remember_me">Remember Me</label>
                                        </div>
                                    </div>

                                    <!-- Actions -->

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <button type="submit" role="button" class="btn btn-primary w-100">Sign
                                                In</button>
                                            {{-- <a href="./index.html" role="button" class="btn btn-primary w-100">Sign In</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- End Login Form -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
