<!DOCTYPE html>
<html lang="en">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <title>Total Association</title>
   <!-- Iconic Fonts -->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <link href="/vendors/iconic-fonts/font-awesome/css/all.min.css" rel="stylesheet">
   <link rel="stylesheet" href="/vendors/iconic-fonts/flat-icons/flaticon.css">
   <link rel="stylesheet" href="/vendors/iconic-fonts/cryptocoins/cryptocoins.css">
   <link rel="stylesheet" href="/vendors/iconic-fonts/cryptocoins/cryptocoins-colors.css">
   <!-- Bootstrap core CSS -->
   <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
   <!-- jQuery UI -->
   <link href="/assets/css/jquery-ui.min.css" rel="stylesheet">
   <!-- Medboard styles -->
   <link href="/assets/css/style.css" rel="stylesheet">

   <!-- Favicon -->
   <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon.png">
</head>

<body class="ms-body ms-primary-theme ms-logged-out">
   <!-- Setting Panel -->
   <div class="ms-settings-panel ms-d-block-lg">
      <div class="row">
         <div class="col-xl-4 col-md-4">
            <h4 class="section-title">Customize</h4>
            <div>
               <label class="ms-switch">
                  <input type="checkbox" id="dark-mode">
                  <span class="ms-switch-slider round"></span>
               </label>
               <span> Dark Mode </span>
            </div>

         </div>
         <div class="col-xl-4 col-md-4">
            <h4 class="section-title">Keyboard Shortcuts</h4>
            <p class="ms-directions mb-0"><code>Esc</code> Close Quick Bar</p>
            <p class="ms-directions mb-0"><code>Alt + (1 -> 6)</code> Open Quick Bar Tab</p>
            <p class="ms-directions mb-0"><code>Alt + Q</code> Enable Quick Bar Configure Mode</p>
         </div>
      </div>
   </div>
   <!-- Preloader -->
   <div id="preloader-wrap">
      <div class="spinner spinner-8">
         <div class="ms-circle1 ms-child"></div>
         <div class="ms-circle2 ms-child"></div>
         <div class="ms-circle3 ms-child"></div>
         <div class="ms-circle4 ms-child"></div>
         <div class="ms-circle5 ms-child"></div>
         <div class="ms-circle6 ms-child"></div>
         <div class="ms-circle7 ms-child"></div>
         <div class="ms-circle8 ms-child"></div>
         <div class="ms-circle9 ms-child"></div>
         <div class="ms-circle10 ms-child"></div>
         <div class="ms-circle11 ms-child"></div>
         <div class="ms-circle12 ms-child"></div>
      </div>
   </div>
   <!-- Overlays -->
   <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
   <div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>
   <!-- Sidebar Navigation Left -->

   <!-- Main Content -->
   <main class="body-content">
      <!-- Navigation Bar -->

      <!-- Body Content Wrapper -->
      <div class="ms-content-wrapper ms-auth">
         <div class="ms-auth-container">
            <div class="ms-auth-col">
               <div class="ms-auth-bg"></div>
            </div>
            <div class="ms-auth-col">
               <div class="ms-auth-form">
                  <form method="POST" action="{{ route('password.email') }}">
                     @csrf
                     <div style="text-align:center;padding-bottom:40px"> <img src="/assets/img/TAS-Logo.png" alt="logo" style="width:200px"> </div>
                     <h1>Forgot Password</h1>
                     @if (session('status'))
                     <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                     </div>
                     @endif
                     <p class="account-subtitle"> Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one</p>
                     <div class="mb-3">
                        <label for="validationCustom08">Email Address</label>
                        <div class="input-group">
                           <input type="email" class="form-control" id="validationCustom08" name="email" placeholder="Email Address" required="">
                           <div class="invalid-feedback">
                              Please provide a valid email.
                           </div>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="ms-checkbox-wrap">
                           <input class="form-check-input" type="checkbox" value="">
                           <i class="ms-checkbox-check"></i>
                        </label>
                        <span> {{ __('Remember me') }}</span>
                        <label class="d-block mt-3"><a href="{{ route('login') }}" class="btn-link">Login Instaed</a></label>
                     </div>
                     <button class="btn btn-primary mt-4 d-block w-100" type="submit">Sign In</button>

                  </form>
               </div>
            </div>
         </div>
      </div>

      <!-- Global Required Scripts Start -->
      <script src="/assets/js/jquery-3.3.1.min.js"></script>
      <script src="/assets/js/popper.min.js"></script>
      <script src="/assets/js/bootstrap.min.js"></script>
      <script src="/assets/js/perfect-scrollbar.js"> </script>
      <script src="/assets/js/jquery-ui.min.js"> </script>
      <!-- Global Required Scripts End -->
      <!-- Medboard core JavaScript -->
      <script src="/assets/js/framework.js"></script>
</body>

</html>














<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
   <title>baskego</title>

   <!-- Favicon -->
   <link rel="shortcut icon" type="image/x-icon" href="../admin/assets/img/favicon.png">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="../admin/assets/css/bootstrap.min.css">

   <!-- Fontawesome CSS -->
   <link rel="stylesheet" href="../admin/assets/css/font-awesome.min.css">

   <!-- Main CSS -->
   <link rel="stylesheet" href="../admin/assets/css/style.css">

   <!--[if lt IE 9]>
    <script src="../admin/assets/js/html5shiv.min.js"></script>
    <script src="../admin/assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

   <!-- Main Wrapper -->
   <div class="main-wrapper login-body">
      <div class="login-wrapper">
         <div class="container">
            <div class="loginbox">
               <div class="login-left">
                  <img class="img-fluid" src="../admin/assets/img/logo.png" alt="Logo">
               </div>
               <div class="login-right">
                  <div class="login-right-wrap">
                     <h1>Forgot Password</h1>
                     <p class="account-subtitle"> Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one</p>
                     @if (session('status'))
                     <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                     </div>
                     @endif
                     <!-- Form -->
                     <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                           <input class="form-control" id="password" name="email" type="email" value="" placeholder="Email">
                        </div>


                        <div class="form-group">
                           <button class="btn btn-primary btn-block" type="submit">
                              Email Password Reset Link</button>
                        </div>

                     </form>
                     <!-- /Form -->

                     <div class="text-center forgotpass"><a href="{{ route('login') }}">Login Instaed</a></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- /Main Wrapper -->

   <!-- jQuery -->
   <script src="../admin/assets/js/jquery-3.2.1.min.js"></script>

   <!-- Bootstrap Core JS -->
   <script src="../admin/assets/js/popper.min.js"></script>
   <script src="../admin/assets/js/bootstrap.min.js"></script>

   <!-- Custom JS -->
   <script src="../admin/assets/js/script.js"></script>

</body>

</html>