<?php 
session_start();
	require_once "../app/includes/logic/user.php";

    $response = '';
	if(isset($_POST['sendMeCode'])){
        unset($_POST['sendMeCode']);
		$response = sendResetPwdCode($_POST);
	}

// Header

require_once '../app/includes/partials/header.php';
?>

</head>
<body class="light-gray">
<div class="styled-wrapper p-5" style="margin-top: 7rem;">
    <form class="form" action="" method="post">
        <h4>Oublie votre mot de passe? Ne t'inquiete pas.</h4>
        <p>Vous pouvez facilement le reinitialiser,Juste entrez votre email et tu aura un code que vous devez saissisez.</p>
        <p class="text-danger"><?= $response ?></p>
      <input type="text" name="email" id="" class="form-control w-75 mb-3" placeholder="Email">
      <button type="submit" name="sendMeCode" class="btn btn-primary">Envoyer moi le code</button>
    </form>
</div>
</body>
</html>