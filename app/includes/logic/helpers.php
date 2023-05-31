<?php

use PHPMailer\PHPMailer\PHPMailer;

require dirname(__DIR__) . '/../../vendor/autoload.php';
require_once dirname(__DIR__) . '../../config/db.php';


$connection = getConnection();

// Redirect to another page

function redirect($page, $params){
    
	if(count($params) > 0)
	{
		$page .= '.php?';

		$params = array_map(function ($key, $value) {
			return "$key=$value";
		}, array_keys($params), array_values($params));

		$paramsStr = implode('&', $params);
		$page .= $paramsStr;
	}

    header("Location: $page");
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

    $errors = [];

    foreach($data as $input => $val)
	{

		if(!isset($rules[$input]))
		{
			continue;
		}

		// Get the rules array
		$inputRules = $rules[$input];

		foreach($inputRules as $rule)
		{
			if(checkRule($input, $val, $rule))
			{
				// If it's the first error intiliaize the array
				// otherwise push to the array

				if(!isset($errors[$input]))
				{
					$errors[$input] = [];
				}

				array_push($errors[$input], checkRule($input, $val, $rule));
			}
		}
	}

	return $errors;
}

function checkRule($inputName, $value, $rule){

	global $connection;

	// Get the human readable input name like from 'full_name' to 'full name' 
	// And also the french translation
	// NOTE: you can skip this part and in the checkRule function
	// you call it with 'inputName' variable instead of 'translatedInputName'

	$translatedInputName = getInputName($inputName);

	// Rules which you can modify(add/edit/remove)

	switch($rule)
	{

		// Required

		case 'required': {
			if(empty($value) || str_starts_with($value, 'choisi'))
			{
				return "$translatedInputName est obligatoires!";
			}
		} break;

		//Email

		case 'email': {
			if(!filter_var($value, FILTER_VALIDATE_EMAIL))
			{
				return 'email doit etre valid!';
			}
		} break;

		// Unique

		case str_starts_with($rule, 'unique'): {
			$splitRule = explode(':', $rule);
			$table = $splitRule[1];
			$idToIgnore = $splitRule[2] ?? true;
			$column = $inputName;
			
			$sql = "SELECT * FROM $table WHERE $column  = ? and id != ?";
		
			if($stmt = $connection->prepare($sql))
			{
				$table = $table;
				$stmt->bindParam(1, $value);
				$stmt->bindParam(2, $idToIgnore);

				$stmt->execute();
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				return count($result) > 0 ? "$translatedInputName dèja existe!" : '';
			}

		} break;
		

		// Minimun number of characters
		
		case str_starts_with($rule, 'min'): {
			$splitRule = explode(':', $rule);
			$length = (int) $splitRule[1];

			if(strlen($value) < $length)
			{
				return "$translatedInputName ne peut pas etre moins d'un $length characteres!";
			}
		} break;

		// File types
		
		case str_starts_with($rule, 'ftypes'): {
			
			if(!$value['name'])
			{
				break;
			}

			$acceptedExts = explode(',', explode(':', $rule)[1]);
			$fileExt = explode('.', $value['name'])[1];

			if(!in_array($fileExt, $acceptedExts))
			{
				return "$translatedInputName doit etre de type: " . implode(',', $acceptedExts);
			}
		} break;

		// Maximun number of characters
		
		case str_starts_with($rule, 'max'): {
			$splitRule = explode(':', $rule);
			$length = (int) $splitRule[1];

			if(strlen($value) > $length)
			{
				return "$translatedInputName ne peut pas etre plus d'un $length characteres!";
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
			$password = htmlspecialchars($_POST['password_confirm']);
			if($value != $password)
			{
				return 'Les mot de passes ne sont pas authentique!';
			}
		} break;

		// Phone number
		// NOTE: this validation only works on Morrocan phone numbers

		case 'phone': {
			if(!preg_match('/^0(6|7)[0-9]{8}$/', $value))
            {
                return "$translatedInputName n'est pas valid";
            } 
		} break;
	}

	return null;
	
}


function getInputName($input) {

	// Input names french translation
	$toFrench = [
		'password' => 'mot de passe',
		'full name' => 'nom complet',
		'branch' => 'filiere',
		'name' => 'nom',
		'phone number' => 'telephone',
		'title' => 'titre',
		'doc desc' => 'description',
		'page count' => 'nombre de page',
		'doc img' => 'image',
		'author' => 'auteur',
		'copies left' => 'nombre de copies'
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

// Send emails

function sendEmail($options){
	$mail = new PHPMailer();

	$mail->setFrom('email');
	$mail->addAddress($options['to']);
	$mail->Subject = $options['subject'] ?? '';
	$mail->isHTML();
	$mail->Body = $options['body'] ?? '';

	$mail->isSMTP();
	$mail->Host = "smtp.gmail.com";
	$mail->SMTPAuth = true;
	$mail->Username = "email";
	$mail->Password = "password";
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	$mail->Port = 587;

	return $mail->send();
}

// Paginate data

function paginate($nbrItemsPerPage, $table, $filtersString = '', $sqlParams = []){

	// Get the query function name
	$queryFn = getQueryFunctionName($table);

	// Count items
	$countSql = 'SELECT count(d.id) as total from documents d
				LEFT JOIN doc_types t ON d.type_id=t.id';
	// $countSql .= $table;
	$countSql .= $filtersString;

	$countResult = $queryFn($countSql, $sqlParams);
    $totalDocs = $countResult[0]['total'];
    
	// Do calculation
    $currentPage = htmlspecialchars(abs($_GET['page'] ?? 1));
    $nbrPages = ceil($totalDocs / $nbrItemsPerPage);
    $startOffset = ($currentPage - 1) * $nbrItemsPerPage;

    array_push($sqlParams, $startOffset, $nbrItemsPerPage);

	$getSql = str_replace('count(d.id) as total', 'd.*, t.name as type', $countSql);
    $getSql .= ' limit ?,?';

	// Get items
    $items = customDocumentQuery($getSql, $sqlParams);

	return array(
		'items' => $items,
		'nbrOfPages' => $nbrPages,
		'currentPage' => $currentPage 
	);

}

// This function is used to get the function
// name for sql queries like (customDocumentsQuery, customUsersQuery)

function getQueryFunctionName($tableName){

	return 'custom' . ucfirst(rtrim($tableName, 's')) .  'Query';
}