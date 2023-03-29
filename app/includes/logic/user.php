<?php 

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require dirname(__DIR__) . "/../config/db.php";
	require "helpers.php";
	require dirname(__DIR__) . "./data/user.php";
	require dirname(__DIR__) . '/../../vendor/autoload.php';


	// Database connection
	$conn = getConnection();

	// Max live time for OTP reset password code in seconds
	define('MAX_OTP_LIVE_TIME', 60 * 5);

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
			$_SESSION["user_id"] = $user['userId'];
			redirect('home');
		}
	}

	// Logout

	function logoutUser(){
		session_unset();
		session_destroy();
		header("location: home.php");
		exit();
	}

	// Send reset password code

	function sendResetPwdCode($data) {
     $email = htmlspecialchars(trim($data['email']));

	 if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		return "Email n'est pas valid";
	}
    
	$result = getUserByIDOrEmail($email);
	

	if(!$result)
	{
		return 'Il n\'existe aucun compte avec cette email'; 
	}

	// Store userId
	$_SESSION['user_id'] = $result['userId'];

	// Send the code
	$str = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz";
	$code = substr(str_shuffle($str), 0, 8);

	$to = $email; 
    $body = "Votre code de reinitialisation est <b>$code</b>";

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->Host = "smtp.gmail.com";
	$mail->SMTPAuth = true;
	$mail->Username = "username";
	$mail->Password = "password";
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	$mail->Port = 587;
	$mail->setFrom('username');
	$mail->addAddress($to);
	$mail->Subject = 'Reinitialisation du mot de passe';
	$mail->isHTML(true);
	$mail->Body = $body;

	if(!$mail->send())
	{
		return 'Erreur lors d\'envoi du email!';
	}

    //  Store the reset code 
	$_SESSION['reset_code'] = $code;
    
	// Set the last_activity session variable, Wich will be used
	// To check if the OTP code has been expired
	$_SESSION['last_activity'] = time();

	redirect('resetPwdCode');

	}

	// Verify password reset code

	function verifyPwdResetCode($data){

        // Clear the OTP code if it's expired
		if(isset($_SESSION['reset_code']))
		{
			clearSessVarIfTimedOut('reset_code', MAX_OTP_LIVE_TIME);
		}

		$userResetCode = htmlspecialchars(trim($data['reset_code']));
		$appResetCode = $_SESSION['reset_code'] ?? null;

		if(!$appResetCode || $userResetCode != $appResetCode)
		{
			return 'Le code n\'est pas valid!';
		}


		redirect('newPassword');
	}

	// Change password for resetting

	function changePassword($data){
     $password = htmlspecialchars(trim($data['pwd']));
     $re_password = htmlspecialchars(trim($data['re_pwd']));

	 if($password != $re_password)
	 {
		return 'Mot de passe ne match pas!';
	 }

	 if(strlen($password) < 8)
	 {
		return 'Le mot de passe doit etre au moins 8 characteres';
	 }

	 $userId = $_SESSION['user_id'];
	 $user = getUserByIDOrEmail($userId);
	 $user['password'] = $password;

	//  Hash the password
	$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

	 updateUser($user);

	 redirect('login');
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