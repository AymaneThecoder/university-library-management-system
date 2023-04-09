<?php


// Redirect to another page

function redirect($page){
    header("Location: $page.php");
    die();
}

// Clear a session variable after certain amount of time

function clearSessVarIfTimedOut($variableName, $timeoutSec){

    if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeoutSec)
    {
        unset($_SESSION[$variableName], $_SESSION['last_activity']);
    } 

}



//Sanitize user inputs

function sanitizeUserData(&$data){
	foreach($data as $key => $value)
	{
		$data[$key] = htmlspecialchars(trim($value), ENT_QUOTES);
	}
}


// Validate forms user data

function validateUserData($data, $rules){

    $error = '';

    foreach($data as $input => $val)
	{
		// Get the rules array
		$inputRules = $rules[$input];
        
		// Get the human readable input name like from 'full_name' to 'full name' 
		// And also the french translation
		// NOTE: you can skip this part and in the checkRule function
		// you call it with 'input' variable instead of 'inputName'

		$inputName = getInputName($input);

		foreach($inputRules as $rule)
		{
			$error = checkRule($inputName, $val , $rule);

			// Return the error when the first one found
			if(!empty($error))
			{
				return $error;
			}
		}
	}

	// The form is valid

	return 'validated';
}

function checkRule($inputName, $value, $rule){

	// Rules which you can modify(add/edit/remove)

	switch($rule)
	{

		// Required

		case 'required': {
			if(empty($value) || str_starts_with($value, 'choisi'))
			{
				return 'Tous les champs sont obligatoires!';
			}
		} break;

		//Email

		case 'email': {
			if(!filter_var($value, FILTER_VALIDATE_EMAIL))
			{
				return 'email doit etre valid!';
			}
		} break;
		

		// Minimun number of characters
		
		case str_starts_with($rule, 'min'): {
			$splitRule = explode(':', $rule);
			$length = (int) $splitRule[1];

			if(strlen($value) < $length)
			{
				return "$inputName ne peut pas etre moins d'un $length characteres!";
			}
		} break;

		// Maximun number of characters
		
		case str_starts_with($rule, 'max'): {
			$splitRule = explode(':', $rule);
			$length = (int) $splitRule[1];

			if(strlen($value) > $length)
			{
				return "$inputName ne peut pas etre plus d'un $length characteres!";
			}
		} break;

		// Check for full_name by checking if there is a space between

		case 'fullName': {
		if(!preg_match("/^[A-Za-z]+(\s[A-Za-z'-]+)+$/", htmlspecialchars_decode($value, ENT_QUOTES)))
			{
				return "Nom complet n'est pas valid!";
			}
		} break;

		// Password confirmation

		case 'confirmed': {
			$password = htmlspecialchars($_POST['password']);
			if($value != $password)
			{
				return 'Les mot de passes ne sont pas authentique!';
			}
		} break;
	}
	
}


function getInputName($input) {

	// Input names french translation
	$toFrench = [
		'password' => 'mot de passe',
		'full name' => 'nom complet',
		'major' => 'filiere'
	];

	$inputNameFormatted = formatInputName($input);

  	return $toFrench[$inputNameFormatted] ?? $inputNameFormatted;
}

//Format input name

function formatInputName($name) {
	return implode('',
	array_map(function($character) {

	   if(preg_match("/_|-/", $character))
	   {
		   return ' ';
	   } elseif(preg_match("/[A-Z]/", $character)) {
		   return ' ' .  strtolower($character);
	   }
	   return $character;

   	}, str_split($name)
   		)
	);
}