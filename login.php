<!DOCTYPE html>
<html>
<?php
require "api/vars.php";
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - DuckID</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
</head>

<body class="bg-gradient-primary">
    <div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <b>Attention</b>: This is the Ticket Support Site for <?php echo $st_name; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
                        </div>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    
                    <div class="card-body p-0">
                        
                        <div class="row">
                        
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/img/dogs/image3.jpeg&quot;);"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Welcome Back!</h4>
                                    </div>
                                    <form class="user"><a class="btn btn-primary btn-block text-white btn-facebook btn-user" role="button" href="api/handling/login.php"><i class="fab fa-discord"></i>&nbsp; Login with Discord</a>
                                        <hr>
                                        
                                    </form>
                                    <div class="alert alert-danger" role="alert">
                                        <b>Attention</b>: If you don't have an account, please make sure to read our <a href="privacy_policy.php">Privacy Policy</a>! <b><u>An account will be created automatically after logging in with <span style="color:blue;">Discord</span>!</u></b>
                                        <br>
                                        We save:
                                        <ul>
                                            <li>your Email (linked to your Discord Account)</li>
                                            <li>your Discord Username (e.g. "Discord#0000") and your Discord ID</li>
                                            <li>your locale</li>
                                            <li>Usage Data (any tickets you create, everything you submit in the tickets)</li>
                                        </ul>
                                        Read more about what is getting saved in our <a href="#">Documentation</a>!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>