<?php

$response = array();
include 'db/db_connect.php';
include 'functions.php';
 
/* Get the input request parameters */
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array
 
/* Check for Mandatory parameters */
if(isset($input['email']) && isset($input['password'])){
	$email = $input['email'];
	$password = $input['password'];
	$query = "SELECT name, institution, birth_date, gender, password_hash, salt FROM user WHERE email = ?";
 
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s", $email);
		$stmt->execute();		
		$stmt->bind_result($name, $institution, $birth_date, $gender, $passwordHashDB, $salt);
		if($stmt->fetch()){
			/* Validate the password */
			if(password_verify(concatPasswordWithSalt($password, $salt), $passwordHashDB)){
				$response["status"] = 0;
				$response["message"] = "Login successful";
				$response["name"] = $name;
				$response["institution"] = $institution;
				$response["birth_date"] = DateTime::createFromFormat('Y-m-d', $birth_date)->format('d-m-Y');
				$response["gender"] = $gender;
			}
			else{
				$response["status"] = 1;
				$response["message"] = "Invalid username or password";
			}
		}
		else{
			$response["status"] = 1;
			$response["message"] = "Invalid username or password";
		}
		$stmt->close();
	}
}
else{
	$response["status"] = 2;
	$response["message"] = "Missing mandatory parameters";
}
/* Display the JSON response */
echo json_encode($response);

?>