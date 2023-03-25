<?php 

	require dirname(__DIR__) . "/../config/db.php";
	require dirname(__DIR__) . "./data/user.php";

	$conn = getConnection();

    // SIGNUP

	function registerUser($data){
		global $conn;
		$fillable = array('email', 'full_name', 'password', 'major');
		
		foreach($data as $key => $value)
		{
			if(in_array($key, $fillable))
			{
				$$key = htmlspecialchars(trim($value));
			}
		}

		$confirm_password = $data['confirm_password'];

        // Check for empty fields
		foreach($fillable as $key) {
			if(empty($data[$key]) || empty($confirm_password) || str_starts_with($major, 'choisi')){
				return "Tous les champs sont obligatoires";
			}
		}

		// Check for valid fullNam

		if(!strpos($full_name, ' '))
		{
			return 'Le nom doit etre complet!';
		}

		// Check for valid email
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			return "Email n'est pas valid!";
		}

		// Check for already taken email
		$result = getUserByIDOrEmail($email);

		if($result != NULL){
			return "Email d'utilisateur deja existe";
		}

		if(strlen($password) < 8){
			return "Mot de passe trop court!";
		}

		if($password != $confirm_password){
			return "Confirmation mot de passe incorrecte!";
		}

		// Hash the password
		$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

		addUser($full_name, $email, $major, $hashedPwd);
	}


	// LOGIN

	function loginUser($data){

		foreach($data as $key => $value)
		{
			$$key = htmlspecialchars(trim($value));
		}

		// Check for empty fields
		if($email == "" || $password == ""){
			return "Les deux champs sont obligatoire!";
		}

		
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);

		// Check for invalid email
		if(!$email)
		{
			return "Email doit etre valid!";
		}

	    $user = getUserByIDOrEmail($email);
   
		// Check for invalid login
		if($user == NULL){
			return "erreur dans email ou password";
		}

		if(!password_verify($password, $user['password'])){
			return "Le mot de passe est incorrecte!";
		}else{
		    session_start();
			$_SESSION["userId"] = $user['userId'];
			header("location: home.php");
			exit();
		}
	}

	function logoutUser(){
		session_destroy();
		header("location: login.php");
		exit();
	}

	function passwordReset($email){
		global $conn;
		$connect = $conn;
		$email = trim($email);

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			return "Email is not valid";
		}

		$stmt = $connect->prepare("SELECT email FROM adherent WHERE email = ?");
		$stmt->bindParam("s", $email);
		$stmt->execute();
		$result = $stmt->fetchAll();

		if($result == NULL){
			return "Email doesn't exist in the database";
		}

		$str = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz";
		$password_length = 7;
		$new_pass = substr(str_shuffle($str), 0, $password_length);
		
		$hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

		$stmt = $connect->prepare("UPDATE adherent SET password = ? WHERE email = ?");
		$stmt->bindParam("ss", $hashed_password, $email);
		$stmt->execute();

		$to = $email; 
		$subject = "Password recovery"; 
		$body = "You can log in with your new password". "\r\n";
		$body .= $new_pass; 

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: aymanemltr@gmail.com \r\n";

		$send = mail($to, $subject, $body, $headers); 
		if(!$send){ 
			return "Email not send. Please try again";
		}else{
			return "success";
		}
	}

	function deleteAccount(){
		global $conn;
		$connect = $conn;

		$sql = "DELETE FROM users WHERE username = ?";
		$stmt = $connect->prepare($sql);
		$stmt->bindParam("s", $_SESSION['user']);
		$stmt->execute();
			session_destroy();
			header("location: delete-message.php");			
			exit();
		
	}