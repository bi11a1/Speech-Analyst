<?php
	function process_speech($file_name, $language){
		# echo $file_name, " ", $language, "<br>";

		# $cmd = "python recognizer.py ".$file_name." ".$language." 2>&1";
		# $cmd = "python3 combined_analysis.py ".$file_name." ".$language." 2>&1";
		$cmd = "python3 combined_analysis.py ".$file_name." ".$language;
		# echo $cmd;
		$res = shell_exec( $cmd );
		return $res;
	}
?>


<?php
	include 'android/db/db_connect.php';
	session_start();
	$_SESSION['access'] = 'none';

	$admin = 0;
	if(isset($_SESSION['status']) && $_SESSION['status']=="admin"){
		$admin = 1;
	}
	
	if(!isset($_GET['speech_no']) && $admin!=1){
		// TODO: Warn user that no speech_no is found
		header('Location: home.php');
	}
	else{
		$speech_no = $_GET['speech_no'];

		$query = "SELECT language, file_name, suspicious FROM speech
					WHERE speech_no = ?";

		if($stmt = $con->prepare($query)){
			$stmt->bind_param("i", $speech_no);
			$stmt->execute();
			$stmt->bind_result($language, $file_name, $suspicious);
			if(!($stmt->fetch())){
				// TODO: Speech number not found
				header('Location: home.php');
			}
			$stmt->close();

			$res = process_speech($file_name, $language);
			
			if($language != "Bengali") $suspicious = -1;
			else $suspicious = $res + 1;

			$query = "UPDATE speech SET suspicious = ? WHERE speech_no = ?";
			if($stmt = $con->prepare($query)){
				$stmt->bind_param("ii", $suspicious, $speech_no);
				$stmt->execute();
			}
			$stmt->close();

			# print($suspicious);
			header('Location: show_speech.php?speech_no='.$speech_no);
		}
	}
?>