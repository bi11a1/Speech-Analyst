<?php

$response = array();
include 'db/db_connect.php';
include 'functions.php';
 
/* Get the input request parameters */
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array
 
/* Check for Mandatory parameters */
if(isset($input['KEY_EMAIL']) && isset($input['KEY_PASSWORD']) && isset($input['KEY_NAME'])){
	$name = $input['KEY_NAME'];
	$email = $input['KEY_EMAIL'];
	$institution = $input['KEY_INSTITUTION'];
	$birth_date = DateTime::createFromFormat('d-m-Y', $input['KEY_BIRTHDATE'])->format('Y-m-d');
	$gender = $input['KEY_GENDER'];
	$password = $input['KEY_PASSWORD'];

	$query = "SELECT password_hash, salt FROM user WHERE email = ?";
 
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($passwordHashDB, $salt);
		if($stmt->fetch()){
			$stmt->close();
			if(password_verify(concatPasswordWithSalt($password, $salt), $passwordHashDB)){
				$query = "UPDATE user SET name = ?, institution = ?, birth_date = ?, gender = ? WHERE email = ?";

				if($stmt = $con->prepare($query)){
					$stmt->bind_param("sssss", $name, $institution, $birth_date, $gender, $email);
					$stmt->execute();
					$response["status"] = 1;
					$response["message"] = "Profile Updated Successfully";
				}
				else{
					$response["status"] = 0;
					$response["message"] = "Something Went Wrong";	
				}
				$stmt->close();
			}
			else{
				$response["status"] = 0;
				$response["message"] = "Invalid Password";
			}
		}
	}
	else{
		$response["status"] = 0;
		$response["message"] = "Invalid Request";
	}
}
else{
	$response["status"] = 2;
	$response["message"] = "Missing mandatory parameters";
}

/* Display the JSON response */
echo json_encode($response);

?>