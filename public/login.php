<?php 
	require_once "../app/includes/logic/user.php";
	if(isset($_POST['submit'])){
		$response = loginUser($_POST);
	}

// Header

require_once '../app/includes/partials/header.php';
?>

<link rel="stylesheet" href="http://localhost/management-of-library/public/css/login.css?v=6">
</head>
<body>

<form method="post"   action="" class="register-form" id="login-form" autocomplete="off" >

        <section class="sign-in">
            <div class="container mt-5">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="./assets/images/signin-image.jpg" alt="sing up image"></figure>
                        <p class="signup-image-link">Vous n'avez pas un compte? <a href="signup.php" class=""> Creer le ici</a></p> 
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Se connecter</h2>
                          <p class="error" style="color:red ;"><?php echo @$response; ?></p>
                            <div class="form-group">
                                <label for="your_name"><i class="fa fa-user"></i></label>
                                <input type="text"  id="your_name" placeholder="Email" name="email" value="<?php echo @$_POST['email']; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="fa fa-lock"></i></label>
                                <input type="password" id="your_pass" placeholder="Password" name="password" value="" />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me"/>
                                <label for="remember-me">Souvien moi</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="submit"  class="form-submit"  value="Login"/>
                            </div>
                            <a href="forgotPassword.php" class="signup-image-link">Oublie mot de passe</a>
                            
                        </div>
                    </div>
                </div>
            </section>
            
        </div> 
    </form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="vendor/jquery/jquery.min.js"></script>
</body>
</html>
