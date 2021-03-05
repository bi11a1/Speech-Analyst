<?php

$response  = array();
include 'db/db_connect.php';

$save_path = 'files/';

/* Creates a random string for naming the file */
function getRandomString($length){
	return bin2hex(openssl_random_pseudo_bytes($length));
}

/* Checking if the filename already exists */
function fileNameExists($file_name){
	$query = "SELECT file_name FROM speech WHERE file_name = ?";
	global $con;
	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s", $file_name);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		if($stmt->num_rows >= 1){
			$stmt->close();
			return true;
		}
		$stmt->close();
	}
	return false;
}

 
if(isset($_FILES['file']['name'])){

	$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

	$file_name = getRandomString(31).'.'.$ext;
	while (fileNameExists($file_name)) {
		// If the random file name already exists then choose another name
		$file_name = getRandomString(31).'.'.$ext;
	}

	$save_path = $save_path.$file_name;

	try {
		// Throws exception in case file is not being moved
		if(!move_uploaded_file($_FILES['file']['tmp_name'], $save_path))
		{
			$response['status'] = -1;
			$response['message'] = 'Could not upload the file!';
		}
		else{
			// File successfully uploaded. set status flag to 0
			$response['message'] = 'File uploaded successfully!';
			$response['file_name'] = $file_name;
			$response['status'] = 0;
		}
	} 
	catch(Exception $e) {
		// Exception occurred. set status flag to - 2
		$response['status'] = -2;
		$response['message'] = $e->getMessage();
	}
}
else {
	// File parameter is missing
	$response['status'] = -3;
	$response['message'] = 'Incomplete request';
}

// Echo final json response to client
echo json_encode($response);
 
?>