<?php
$settings = \Package\August\Http\Controllers\AblockSettingController::getSettingSite();
?>
<!DOCTYPE html>
<html lang="en" data-topbar-color="brand">
    <head>
        <meta charset="utf-8" />
        <title>{{ $settings["site_title"] }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ $settings['site_icon_path'] }}">

		<!-- App css -->
		<link href="/assets-august/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="/assets-august/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

		<!-- icons -->
		<link href="/assets-august/css/icons.min.css" rel="stylesheet" type="text/css" />

		<!-- Theme Config Js -->
		<script src="/assets-august/js/config.js"></script>


    </head>

    <body class="loading">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="card">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="index.html" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="{{ $settings['site_logo_path'] }}" alt="" height="40">
                                            </span>
                                        </a>
                    
                                        <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="{{ $settings['site_logo_path'] }}" alt="" height="40">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                                </div>

                                <form role="form" action="{{ route('august.auth.store') }}" method="post">
                                	@csrf
                                    <div class="mb-2">
                                        <label for="emailaddress" class="form-label">Email address</label>
                                        <input class="form-control" name="email" type="email" id="emailaddress" required="" placeholder="Enter your email">
                                    </div>

                                    <div class="mb-2">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 d-none">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkbox-signin" checked>
                                            <label class="form-check-label" for="checkbox-signin">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-grid mb-0 text-center">
                                        <button class="btn btn-primary" type="submit"> Log In </button>
                                    </div>

                                </form>

                                <div class="text-center d-none">
                                    <h5 class="mt-3 text-muted">Sign in with</h5>
                                    <ul class="social-list list-inline mt-3 mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-purple text-purple"><i class="mdi mdi-facebook"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                        </li>
                                    </ul>
                                </div>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3 d-none">
                            <div class="col-12 text-center">
                                <p> <a href="auth-recoverpw.html" class="text-muted ms-1">Forgot your password?</a></p>
                                <p class="text-muted">Don't have an account? <a href="auth-register.html" class="text-primary fw-medium ms-1">Sign Up</a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt d-none">
            <script>document.write(new Date().getFullYear())</script> &copy; Minton theme by <a href="" class="text-dark">Coderthemes</a> 
        </footer>

        <!-- Vendor js -->
        <script src="/assets-august/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="/assets-august/js/app.min.js"></script>
        
    </body>
</html>