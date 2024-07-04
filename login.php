<?php 
session_start();
session_destroy();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    

    <meta charset="utf-8" />
            <title>RSPM - Login</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
            <meta content="" name="author" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />

            <!-- App favicon -->
            <link rel="shortcut icon" href="public/resources/assets/images/head.ico">

       

     <!-- App css -->
     <link href="public/resources/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
     <link href="public/resources/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
     <link href="public/resources/assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body id="body" class="auth-page" style="background-image: url('public/resources/assets/images/bg3.jpg'); background-size: cover; background-position: center center; height: 100vh;">
   <!-- Log In page -->
    <div class="container-md">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div class="card shadow">
                                <div class="card-body p-0" style="background-color: #71baef;">
                                    <div class="text-center p-3">
                                        <a href="login" class="logo logo-admin">
                                            <img src="public/resources/assets/images/lg.png" height="50" alt="logo" class="auth-logo">
                                        </a>
                                        <h4 class="mt-1 mb-1 fw-semibold text-white font-18">RSPM</h4>   
                                        <p class="text-muted  mb-0">Sign in to continue to Menu.</p>  
                                    </div>
                                </div>
                                <div class="card-body pt-0">                                    
                                    <form class="my-4" action="app/controller/cek-login.php" method="post">            
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">                               
                                        </div><!--end form-group--> 
            
                                        <div class="form-group">
                                            <label class="form-label" for="userpassword">Password</label>                                            
                                            <input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password">                            
                                        </div><!--end form-group--> 
            
                                        <div class="form-group row mt-3">
                                            <div class="col-sm-6">
                                                <div class="form-check form-switch form-switch-success">
                                                    <input class="form-check-input" type="checkbox" id="customSwitchSuccess">
                                                    <label class="form-check-label" for="customSwitchSuccess">Remember me</label>
                                                </div>
                                            </div><!--end col--> 
                                            <div class="col-sm-6 text-end">
                                                                                  
                                            </div><!--end col--> 
                                        </div><!--end form-group--> 
            
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-primary" type="submit">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                            </div><!--end col--> 
                                        </div> <!--end form-group-->                           
                                    </form><!--end form-->
                                    <div class="m-3 text-center text-muted">
                                        <p class="mb-0"></p>
                                    </div>
                                    <hr class="hr-dashed mt-4">
                                    <div class="text-center mt-n5">
                                        <h6 class="card-bg px-3 my-4 d-inline-block">Download App</h6>
                                    </div>
                                    <div class="d-flex justify-content-center mb-1">
                                        <a href="https://drive.google.com/file/d/1w1gB2cahkQQX4V77j2tgEegRZj07RzFu/view?usp=sharing" target="_blank" class="d-flex justify-content-center align-items-center thumb-sm  rounded-circle me-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="800" width="1200" id="svg60" version="1.1" viewBox="-4.12599 -7.65905 35.75858 45.9543"><defs id="defs38"><linearGradient gradientUnits="userSpaceOnUse" y2="21.86" x2="-5.9" y1="1.87" x1="14.09" id="linear-gradient"><stop id="stop4" stop-color="#008eff" offset="0"/><stop id="stop6" stop-color="#008fff" offset=".01"/><stop id="stop8" stop-color="#00acff" offset=".26"/><stop id="stop10" stop-color="#00c0ff" offset=".51"/><stop id="stop12" stop-color="#00cdff" offset=".76"/><stop id="stop14" stop-color="#00d1ff" offset="1"/></linearGradient><linearGradient gradientUnits="userSpaceOnUse" y2="15.32" x2="-2.37" y1="15.32" x1="26.45" id="linear-gradient-2"><stop id="stop17" stop-color="#ffd800" offset="0"/><stop id="stop19" stop-color="#ff8a00" offset="1"/></linearGradient><linearGradient gradientUnits="userSpaceOnUse" y2="45.15" x2="-9.41" y1="18.05" x1="17.69" id="linear-gradient-3"><stop id="stop22" stop-color="#ff3a44" offset="0"/><stop id="stop24" stop-color="#b11162" offset="1"/></linearGradient><linearGradient gradientUnits="userSpaceOnUse" y2="3.81" x2="8.92" y1="-8.29" x1="-3.19" id="linear-gradient-4"><stop id="stop27" stop-color="#328e71" offset="0"/><stop id="stop29" stop-color="#2d9571" offset=".07"/><stop id="stop31" stop-color="#15bd74" offset=".48"/><stop id="stop33" stop-color="#06d575" offset=".8"/><stop id="stop35" stop-color="#00de76" offset="1"/></linearGradient><style id="style2">.cls-7{opacity:.07}</style></defs><g transform="translate(.004)" id="g58"><g id="g56"><path id="path40" d="M.55.48A2.39 2.39 0 000 2.15v26.34a2.41 2.41 0 00.55 1.67l.09.09 14.75-14.76v-.35L.64.39z" fill="url(#linear-gradient)"/><path id="path42" d="M20.31 20.41l-4.92-4.92v-.35l4.92-4.91.11.06 5.83 3.31c1.67.94 1.67 2.49 0 3.44l-5.83 3.31z" fill="url(#linear-gradient-2)"/><path id="path44" d="M20.42 20.35l-5-5L.55 30.16a2 2 0 002.45.07l17.39-9.88" fill="url(#linear-gradient-3)"/><path id="path46" d="M20.42 10.29L3 .4A1.93 1.93 0 00.55.48l14.84 14.84z" fill="url(#linear-gradient-4)"/><path id="path48" d="M20.31 20.24L3 30.06a2 2 0 01-2.39 0l-.09.09.09.09a2 2 0 002.39 0l17.39-9.88z" opacity=".1"/><path id="path50" d="M.55 30A2.43 2.43 0 010 28.32v.17a2.41 2.41 0 00.55 1.67l.09-.09z" class="cls-7"/><path id="path52" d="M26.25 16.86l-5.94 3.38.11.11L26.25 17a2.11 2.11 0 001.25-1.72 2.21 2.21 0 01-1.25 1.58z" class="cls-7"/><path id="path54" d="M3 .58l23.25 13.19a2.2 2.2 0 011.25 1.55 2.09 2.09 0 00-1.25-1.72L3 .4C1.36-.54 0 .24 0 2.15v.17C0 .42 1.36-.37 3 .58z" fill="#fff" opacity=".3"/></g></g></svg>
                                        </a>
                                    </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
    <!-- vendor js -->
    
    <script src="public/resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/resources/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="public/resources/assets/libs/feather-icons/feather.min.js"></script>
    <!-- App js -->
    <script src="public/resources/assets/js/app.js"></script>
    
</body>

</html>