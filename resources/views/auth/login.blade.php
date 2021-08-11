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

   <!-- Sidebar Navigation Left -->

   <!-- Main Content -->
   <main class="body-content">
      <!-- Navigation Bar -->

      <!-- Body Content Wrapper -->
      <div class="ms-content-wrapper ms-auth">
         <div class="ms-auth-container">
            <div class="ms-auth-col">
               <div class="ms-auth-form">
                  <form method="POST" action="{{ route('login') }}">
                     <div style="text-align:center;padding-bottom:40px"> <img src="/assets/img/TAS-Logo.png" alt="logo" style="width:200px"> </div>
                     @csrf
                     <h1>Login to Account</h1>
                     @if (session('status'))
                     <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                     </div>
                     @endif
                     <p>Please enter your email and password to continue</p>
                     <div class="mb-3">
                        <label for="validationCustom08">Email Address</label>
                        <div class="input-group">
                           <input type="email" class="form-control" id="validationCustom08" name="email" placeholder="Email Address" required="">
                           <div class="invalid-feedback">
                              Please provide a valid email.
                           </div>
                        </div>
                     </div>
                     <div class="mb-2">
                        <label for="validationCustom09">Password</label>
                        <div class="input-group">
                           <input type="password" name="password" class="form-control" id="validationCustom09" placeholder="Password" required="">
                           <div class="invalid-feedback">
                              Please provide a password.
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="ms-checkbox-wrap">
                           <input class="form-check-input" type="checkbox" value="">
                           <i class="ms-checkbox-check"></i>
                        </label>
                        <span> {{ __('Remember me') }}</span>
                        <label class="d-block mt-3"><a href="{{ route('password.request') }}" class="btn-link">Forgot Password?</a></label>
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