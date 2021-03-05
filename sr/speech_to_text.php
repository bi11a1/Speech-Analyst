<?php
	function process_speech($file_name, $language){
		echo $file_name, " ", $language, "<br>";

		#$cmd = "python recognizer.py ".$file_name." ".$language." 2>&1";
		$cmd = "python3 recognizer.py ".$file_name." ".$language." 2>&1";
		echo $cmd;
		$res = shell_exec( $cmd );
		echo "<pre>$res</pre>";
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
			if($suspicious == 0) $suspicious = "Not processed yet";
			else if($suspicious == 1)$suspicious = "Suspicious";
			else if($suspicious == -1) $suspicious = "Non-suspicious";
			$stmt->close();

			process_speech($file_name, $language);
			header('Location: show_speech.php?speech_no='.$speech_no);
		}
	}
?>