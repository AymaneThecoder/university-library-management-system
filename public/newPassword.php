<?php
session_start();
	require_once "../app/includes/logic/user.php";

    $response = '';
	if(isset($_POST['changePwd'])){
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
      <input type="password" name="pwd" id="" class="form-control w-75 mb-3" placeholder="Password">
      <input type="password" name="re_pwd" id="" class="form-control w-75 mb-3" placeholder="Repeat password">
      <button type="submit" name="changePwd" class="btn btn-primary">Changer le mot de passe</button>
    </form>
</div>
</body>
</html>