<?php

$response  = array();
include 'db/db_connect.php';

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, TRUE); //convert JSON into array

$save_path = 'files/';
 
if(isset($data['KEY_USER_EMAIL']) && isset($data['KEY_TITLE']) && isset($data['KEY_LANGUAGE']) && isset($data['KEY_LOCATION']) && isset($data['KEY_ACTUAL_LOCATION']) && isset($data['KEY_CATEGORY']) && isset($data['KEY_FILE_NAME'])){

	// Get the speech related informations from json formData
	$email = $data['KEY_USER_EMAIL'];
	$title = $data['KEY_TITLE'];
	$language = $data['KEY_LANGUAGE'];
	$location = $data['KEY_LOCATION'];
	$actual_location = $data['KEY_ACTUAL_LOCATION'];
	$key_category = $data['KEY_CATEGORY'];
	$sub_category_1 = $data['KEY_SUB_CATEGORY_1'];
	$sub_category_2 = $data['KEY_SUB_CATEGORY_2'];
	$summary = $data['KEY_SUMMARY'];
	$file_name = $data['KEY_FILE_NAME'];

	// Merging all categories into one
	$category = $key_category;
	if($sub_category_1 != ""){
		$category = $category.", ".$sub_category_1;
	}
	if($sub_category_2 != ""){
		$category = $category.", ".$sub_category_2;
	}

	// Find the user id from the given email address
	$query = "SELECT user_id FROM user WHERE email = ?";
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($user_id);
		if($stmt->fetch()){
			/* User exist, OK */
			$stmt->close();
		}
		else{
			$response["status"] = -3;
			$response["message"] = "Incomplete request";
			$stmt->close();
			echo json_encode($response);
			exit(0);
		}
	}

	
	$insertQuery  = "INSERT INTO speech(user_id, location, actual_location, title, summary, language, category, file_name) VALUES (?,?,?,?,?,?,?,?)";

	if($stmt = $con->prepare($insertQuery)){
		$stmt->bind_param("isssssss", $user_id, $location, $actual_location, $title, $summary, $language, $category, $file_name);
		$stmt->execute();

		// File successfully uploaded. set status flag to 1
		$response['message'] = 'File uploaded successfully!';
		$response['status'] = 1;
		$stmt->close();
	}
	else{
		// Delete file
		unlink($save_path.$file_name);
		$response['message'] = 'Something went wrong!';
		$response['status'] = -2;
	}
}
else {
	// File parameter is missing
	$response['status'] = -3;
	$response['message'] = 'Incomplete Request';
}

// Echo final json response to client
echo json_encode($response);

?>