<?php 
session_start();
	require_once "../app/includes/logic/user.php";
	require_once "../app/includes/logic/helpers.php";

    $response = '';
	if(isset($_POST['verifyCode'])){
		$response = verifyPwdResetCode($_POST);
	}

// Header

require_once '../app/includes/partials/header.php';

?>
</head>
<body class="light-gray">
<div class="styled-wrapper p-5" style="margin-top: 7rem;">
    <form class="form" action="" method="post">
        <h5>Entrez le code que vou avez recue dans votre email</h5>
        <p class="text-danger"><?= $response ?></p>
      <input type="text" name="reset_code" id="" class="form-control w-75 mb-3" placeholder="Code">
      <button type="submit" name="verifyCode" class="btn btn-primary">Verifiez le code</button>
    </form>
</div>
</body>
</html>