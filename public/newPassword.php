<?php
session_start();
	require_once "../app/includes/logic/user.php";


    // Redirect the user to forgot password page
    // If he doesn't have an OTP code
    if(!isset($_SESSION['reset_code']))
    {
        redirect('forgotPassword');
    }

    $response = '';
	if(isset($_POST['changePwd'])){
        unset($_POST['changePwd']);
		$response = changePassword($_POST);
	}

// Header

require_once '../app/includes/partials/header.php';
?>
</head>
<body class="light-gray">
<div class="styled-wrapper p-5" style="margin-top: 7rem;">
    <form class="form" action="" method="post">
        <h5>Choisi votre nouvelle mot de passe</h5>
        <p class="text-danger"><?= $response ?></p>
      <input type="password" name="password" id="" class="form-control w-75 mb-3" placeholder="Mot de passe">
      <input type="password" name="confirm_password" id="" class="form-control w-75 mb-3" placeholder="Confirmer le mot de passe">
      <button type="submit" name="changePwd" class="btn btn-primary">Changer le mot de passe</button>
    </form>
</div>
</body>
</html>