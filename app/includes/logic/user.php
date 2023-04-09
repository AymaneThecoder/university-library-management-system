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



    // This is for signup new user and modify account information

	function registerUser($data){

		//Sanitize data
		sanitizeUserData($data);

		// Validate user data

		$validationResponse = validateUserData($data, [
			'full_name' => ['required', 'fullName'],
			'email' => ['required', 'email'],
			'major' => ['required'],
			'password' => ['required', 'min:8'],
			'confirm_password' => ['required', 'confirmed']
		]);
		
		// There is error in form

		if($validationResponse != 'validated')
		{
			return $validationResponse;
		}

		// Check if the email is already taken 

		$user = getUserByIDOrEmail($data['email']);

        if($user != NULL)
		{
            return "Email deja existe";
        }

		// Hash the password
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

		addUser($data);

		redirect('login');
	}


	// LOGIN

	function loginUser($data){

		// Sanitize data
		sanitizeUserData($data);

		// Validate user data

		$response = validateUserData($data, [
			'email' => ['required', 'email'],
			'password' => ['required']
		]);

		if($response != 'validated')
		{
			return $response;
		}

	    $user = getUserByIDOrEmail($data['email']);
   
		// Check for invalid login
		if($user == NULL){
			return "erreur dans email ou password";
		}

		if(!password_verify($data['password'], $user['password'])){
			return "Le mot de passe est incorrecte!";
		}else{
		    session_start();
			$_SESSION["user_id"] = $user['userId'];
			redirect('home');
		}
	}


	// Update user information

	function modifyUserAccountInfo($data){

		//Sanitize data
		sanitizeUserData($data);

		// Validate user data

		$validationResponse = validateUserData($data, [
			'full_name' => ['required', 'fullName'],
			'email' => ['required', 'email'],
			'major' => ['required'],
			'password' => ['required', 'min:8'],
			'confirm_password' => ['required', 'confirmed']
		]);
		
		// There is error in form

		if($validationResponse != 'validated')
		{
			return $validationResponse;
		}

		// Check if the email is already taken 
		$currentUser = getUserByIDOrEmail($_SESSION['user_id']);
		$user = getUserByIDOrEmail($data['email']);

        if($user != NULL && $user['email'] != $currentUser['email'])
		{
            return "Email deja existe";
        }

		// Hash the password
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		$data['user_id'] = $_SESSION['user_id'];

		updateUser($data);

		//Set the success message
        $_SESSION['profile_modified'] = true;
		
		redirect('login');
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

    $response =  validateUserData($data, []);
	if($response != 'validated')
	{
		return $response;
	}

	$user = getUserByIDOrEmail($email);
	

	if(!$user)
	{
		return 'Il n\'existe aucun compte avec cette email'; 
	}

	// Store userId
	$_SESSION['user_id'] = $user['userId'];

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
     $password = htmlspecialchars(trim($data['password']));

	 $response = validateUserData($data, []);

	 if($response != 'validated')
	 {
		return $response;
	 }

	 $userId = $_SESSION['user_id'];
	 $user = getUserByIDOrEmail($userId);
	 
	//  Hash the password
	$user['password'] = password_hash($password, PASSWORD_DEFAULT);

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