<?php 
	require_once "../app/includes/logic/user.php";
	require_once "../app/includes/data/major.php";
	if(isset($_POST['submit'])){
        unset($_POST['submit']);
		$errors = registerUser($_POST, 'insert');
	}

// Header

require_once '../app/includes/partials/header.php';
?>
<link rel="stylesheet" href="http://localhost/management-of-library/public/css/login.css?v=3">
</head>
<body>

<div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Creer un compte</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <div class="position-relative">
                                    <label for="name"><i class="fa fa-user"></i></label>
                                    <input type="text"  id="name" placeholder="Nom complet" name="full_name" value="<?php echo @$_POST['full_name']; ?>"/>
                                </div>
                                <div class="text-danger"><?= @$errors['full_name'][0] ?></div>
                            </div>
                            <div class="form-group">
                                <div class="position-relative">
                                    <label for="email"><i class="fa fa-envelope"></i></label>
                                    <input type="text" name="email" id="email" placeholder="Email" value="<?php echo @$_POST['email']; ?>"  />
                                </div>
                                <div class="text-danger"><?= @$errors['email'][0] ?></div>
                            </div>
                            <div class="form-group">
                                <div class="position-relative">
                                    <label for="email"><i class="fa fa-phone"></i></label>
                                    <input type="text" name="tele" id="tele" placeholder="Tele" value="<?php echo @$_POST['tele']; ?>"  />
                                </div>
                                <div class="text-danger"><?= @$errors['tele'][0] ?></div>
                            </div>
                            <div class="form-group">
                                <label for="name d-none"><i class="fa fa-graduation-cap"></i></label>
                                <select name="branch" value="<?php echo @$_POST['major']; ?>">
                                    <option value="choisis ta filiere" id="name" >choisissez votre filiere</option>

                                <!-- Fill the majors select -->

                                <?php
                                 $branchs = getMajors();

                                 foreach($branchs as $branch):
                                ?>
                                    <option value="<?= $branch['id'] ?>" <?= @$_POST['major'] == $branch['id'] ? 'selected' : '' ?> > <?= $branch['name'] ?> </option>
                                <?php
                                endforeach;
                                ?>
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <div class="position-relative">
                                    <label for="pass"><i class="fa fa-lock"></i></label>
                                    <input type="password" name="password" id="password" placeholder="Mot de passe"  value=""  />
                                </div>
                                <div class="text-danger"><?= @$errors['password'][0] ?></div>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="fa fa-lock"></i></label>
                                <input type="password"  id="re_pass" placeholder="Repeter mot de passe" name="password_confirm" value="" />
                            </div>

                            <div class="form-group form-button">
                                <input type="submit" name="submit" id="signup" class="form-submit" value="Creer mon compte"/>
                            </div>
                                                 
                    </div>
                    <div class="signup-image">
                        <figure><img src="./assets/images/signup-image.jpg" alt="sing up image"></figure>
                        <p class="signup-image-link">Deja a membre?<a href="login.php">Se connecter</a></p>
                    </div>
                </div>
            </div>
        </section>
        </form>

     
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>