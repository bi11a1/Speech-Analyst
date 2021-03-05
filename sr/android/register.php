<?php
$response = array();
include 'db/db_connect.php';
include 'functions.php';
 
//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array
 
//Check for Mandatory parameters
if(isset($input['email']) && isset($input['password']) && isset($input['name'])){
	$email = $input['email'];
	$password = $input['password'];
	$name = $input['name'];

	//Check if the email is valid
	if(!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
		$response["status"] = -1;
		$response["message"] = "Invalid email format";
	}
	//Check if the email already exist
	else if(!emailExists($email)){
 
		//Get a unique Salt
		$salt = getSalt();
		
		//Generate a unique password Hash
		$passwordHash = password_hash(concatPasswordWithSalt($password, $salt), PASSWORD_DEFAULT);
		
		//Query to register new user
		$insertQuery  = "INSERT INTO user(email, name, password_hash, salt) VALUES (?,?,?,?)";
		if($stmt = $con->prepare($insertQuery)){
			$stmt->bind_param("ssss", $email, $name, $passwordHash, $salt);
			$stmt->execute();
			$response["status"] = 0;
			$response["message"] = "User created";
			$stmt->close();
		}
		else{			
			$response["status"] = 3;
			$response["message"] = "Database Error";
		}
	}
	else{
		$response["status"] = 1;
		$response["message"] = "Email is in use";
	}
}
else{
	$response["status"] = 2;
	$response["message"] = "Missing mandatory parameters";
}
echo json_encode($response);
?>