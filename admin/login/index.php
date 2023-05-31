
<?php
 require_once 'authenticate.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="style.css?v=<?= time() ?>">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<div class="login-error"><?= @$loginError ?></div>
			<form action="" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Nom d'utilisateur" value="<?= @$_POST['username'] ?>" id="username">
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Mot de passe" id="password" required>
				<input type="submit" name="submit-btn" value="Login">
			</form>
		</div>
	</body>
</html>