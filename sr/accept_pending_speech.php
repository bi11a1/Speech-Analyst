<?php
	include 'android/db/db_connect.php';
	session_start();
	$_SESSION['access'] = 'none';

	if(isset($_SESSION['user_id']) && $_SESSION['access']=="all" && isset($_GET['speech_no'])){
		$query = "UPDATE speech SET status = 1, verifier_admin_id = ? WHERE speech_no = ? ";

		if($stmt = $con->prepare($query)){
			$stmt->bind_param("ii", $_SESSION['user_id'], $_GET['speech_no']);
			$stmt->execute();
			$stmt->close();
			echo "Done";
		}
	}
	header('Location: pending_speech.php');
?>