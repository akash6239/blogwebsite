
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Log In | Ubold - Responsive Bootstrap 5 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
		<!-- Theme Config Js -->
		<script src="{{ asset('backend/assets/js/head.js')}}"></script>
		<!-- Bootstrap css -->
		<link href="{{ asset('backend/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />
		<!-- App css -->
		<link href="{{ asset('backend/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

		<!-- Icons css -->
		<link href="{{ asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    </head>

    <body class="authentication-bg authentication-bg-pattern">
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="card bg-pattern">
                            <form action="{{ route('signupuser') }}" method="POST">
                                @csrf
                                <div class="card-body p-4">
                                    <div class="auth-brand">
                                        <a href="/" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="image" height="22">
                                            </span>
                                        </a>
                    
                                        <a href="/" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="image" height="22">
                                            </span>
                                        </a>
                                    </div>
                                    <div class="text-center w-75 m-auto">
                                        {{-- <p class="text-muted mb-4 mt-3">Register</p> --}}
                                        <h3 class="text-black mb-4 mt-3">Register</h3>
                                    </div>
                                    <div class=" w-100 m-auto">
                                        @include('admin.layout.toast')
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input class="form-control" type="text" id="name" placeholder="Name" value="{{ old('name') }}" name="name" >
                                        @error('name')<p class="text-danger">{{ $message }}</p>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input class="form-control" type="email" id="email" placeholder="Email" value="{{ old('email') }}" name="email" >
                                        @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                                    </div>
                            
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control" placeholder="Password" name="password" >
                                            <div class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                        @error('password')<p class="text-danger">{{ $message }}</p>@enderror
                                    </div>
                            
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="remember_token" class="form-check-input" id="checkbox-signin" checked>
                                            <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        If you have an account click <a href="{{ route('login') }}">Login</a>
                                    </div>
                                    <div class="text-center d-grid">
                                        <button class="btn btn-primary" type="submit">Log In</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div> 
                </div>
            </div>
        </div>
        <!-- end page -->
        <script>
            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordInput = document.getElementById('password');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);                
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('backend/assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/app.min.js')}}"></script>
    </body>
</html>