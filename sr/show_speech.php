<?php
	include 'android/db/db_connect.php';
	session_start();
	$_SESSION['access'] = 'none';
	$admin = 0;
	$text_file_name = "";
	if(isset($_SESSION['status']) && $_SESSION['status']=="admin"){
		$admin = 1;
	}
	
	if(!isset($_GET['speech_no'])){
		// TODO: Warn user that no speech_no is found
		header('Location: home.php');
	}
	else{
		$speech_no = $_GET['speech_no'];

		// To get the speech details from speech no
		$query = "SELECT user_id, title, summary, language, category, location, upload_time, file_name, suspicious FROM speech
					WHERE speech_no = ?";
		if($stmt = $con->prepare($query)){
			$stmt->bind_param("i", $speech_no);
			$stmt->execute();
			$stmt->bind_result($user_id, $title, $summary, $language, $category, $location, $upload_time, $file_name, $suspicious);
			if(!($stmt->fetch())){
				// TODO: Speech number not found
				header('Location: home.php');
			}

			$text_file_name = substr($file_name, 0, -3)."txt";

			if(strlen($summary) == 0) $summary = "No description was provided by the author.";
			if($suspicious == 0) $suspicious = "Not processed yet";
			else if($suspicious == 1)$suspicious = "Suspicious";
			else if($suspicious == -1) $suspicious = "Non-suspicious";
			$stmt->close();
		}

		// Use the user_id to get user details
		$query = "SELECT name, institution FROM user WHERE user_id = ?";

		if($stmt = $con->prepare($query)){
			$stmt->bind_param("i", $user_id);
			$stmt->execute();
			$stmt->bind_result($name, $institution);
			if(!($stmt->fetch())){
				// TODO: User not found
				header('Location: home.php');
			}
			$stmt->close();
		}
	}
	include 'header.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Speech Analyst | Show Speech</title>
	<!-- <script type="text/javascript" src="notify/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="notify/notify.js"></script> -->
	<link href="css/home.css" type="text/css" rel="stylesheet">
	<link href="css/show_speech.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<!-- <script>$.notify("Hello", "info");</script> -->

	<!-- For laptop -->
	<div class="row show_speech-laptop">
		<div class="col-1 space">&nbsp</div>

		<div class="col-2 sidebar" style="background-image: linear-gradient(to bottom right, lightblue, white);">
			<center>
				<div class="title"> Speech Analyst </div>
			</center>

            <?php if($_SESSION['access'] == "all"){ ?>
            <div class="about-project">
                <i class="fa fa-angle-right"></i> <a href="pending_speech.php" class="about-link">Pending Speeches</a>
            </div>
            <?php } ?>
            
			<div class="about-project">
				<i class="fa fa-angle-right"></i> About this project
			</div>
			<div class="about-option"><a href="about.php#what_is_it" class="about-link">- What is it?</a></div>
			<div class="about-option"><a href="about.php#how_does_it_work" class="about-link">- How does it work?</a></div>
			<div class="about-option"><a href="about.php#how_to_search" class="about-link">- How to search?</a></div>
			<div class="about-option"><a href="about.php#contact" class="about-link">- Contact</a></div>
		</div>
		<div class="col-8 home-div" style="background-image: linear-gradient(to bottom right, #eafaff, #ffffff);">
			<div class="welcome-div">
				<div class="welcome-header">
					<h1 style="margin-bottom: 0px"><?php echo $title; ?></h1>
					<p style="margin: 0px;"><?php echo $name.", ".$institution; ?></p>
				</div>
				<p class="description-text"><b>Description:<br></b><span><?php echo $summary; ?></span></p>
				<audio controls controlsList="nodownload" style="width: 90%">
				  	<source src="android/files/<?php echo $file_name; ?>" type="audio/ogg">
				  	<source src="android/files/<?php echo $file_name; ?>" type="audio/mpeg">
					Your browser does not support the audio element.
				</audio>
				<div class="speech-details">
					<b>Speech Details:</b><br>
					<table class="table-speech-details">
						<tr>
							<td>Speech Number</td>
							<td>: </td>
							<td><?php echo $speech_no; ?></td>
						</tr>
						<tr>
							<td>Author</td>
							<td>: </td>
							<td><?php echo $name; ?></td>
						</tr>
						<tr>
							<td>Language</td>
							<td>: </td>
							<td><?php echo $language; ?></td>
						</tr>
						<tr>
							<td>Category</td>
							<td>: </td>
							<td><?php echo $category; ?></td>
						</tr>
						<tr>
							<td>Speech Location</td>
							<td>: </td>
							<td><?php echo $location; ?></td>
						</tr>
						<tr>
							<td>Upload Time</td>
							<td>: </td>
							<td><?php echo $upload_time; ?></td>
						</tr>

						<?php if($admin){ ?>
							<tr>
								<td>Text</td>
								<td>: </td>
								<td><?php 
								if(file_exists("android/files/".$text_file_name)==1){
									echo "Click ";?> <a href="android/files/<?php echo $text_file_name; ?>" download="converted_text.txt">here</a> <?php echo " to download the text"; 
								}
								else{
									echo "Click ";?><a href="speech_to_sus.php?speech_no=<?php echo $speech_no; ?>">here</a> <?php echo " to start processing";
								}
								?></td>
							</tr>
							<tr>
								<td>Analysis</td>
								<td>: </td>
								<td><?php 
									$query = "SELECT suspicious FROM speech WHERE speech_no = ?";
									if($stmt = $con->prepare($query)){
										$stmt->bind_param("i", $speech_no);
										$stmt->execute();
										$stmt->bind_result($suspicious);
										$stmt->fetch();
										$stmt->close();

										$show = "Not Processed Yet";
										if($suspicious == 2) {$show = "Suspicious";}
										else if($suspicious == 1) {$show = "Non-Suspicious";}
										else if($suspicious == -1) {$show = "Analysis is Available for Bangla Only";}
										echo $show;
									}
								?></td>
							</tr>
						<?php } ?>
						
					</table>
				</div>
			</div>
		</div>

		<div class="col-1">&nbsp</div>
	</div>

	<!-- For mini-laptop -->
	<div class="row show_speech-mini-laptop">
		<div class="col-3 sidebar" style="background-image: linear-gradient(to bottom right, lightblue, white);">
			<center>
				<div class="title"> Speech Analyst </div>
			</center>

            <?php if($_SESSION['access'] == "all"){ ?>
            <div class="about-project">
                <i class="fa fa-angle-right"></i> <a href="pending_speech.php" class="about-link">Pending Speeches</a>
            </div>
            <?php } ?>
            
			<div class="about-project">
				<i class="fa fa-angle-right"></i> About this project
			</div>
			<div class="about-option"><a href="about.php#what_is_it" class="about-link">- What is it?</a></div>
			<div class="about-option"><a href="about.php#how_does_it_work" class="about-link">- How does it work?</a></div>
			<div class="about-option"><a href="about.php#how_to_search" class="about-link">- How to search?</a></div>
			<div class="about-option"><a href="about.php#contact" class="about-link">- Contact</a></div>
		</div>
		<div class="col-9 home-div" style="background-image: linear-gradient(to bottom right, #eafaff, #ffffff);">
			<div class="welcome-div">
				<div class="welcome-header">
					<h1 style="margin-bottom: 0px"><?php echo $title; ?></h1>
					<p style="margin: 0px;"><?php echo $name.", ".$institution; ?></p>
				</div>
				<p class="description-text"><b>Description:<br></b><span><?php echo $summary; ?></span></p>
				<audio controls controlsList="nodownload" style="width: 90%">
				  	<source src="android/files/<?php echo $file_name; ?>" type="audio/ogg">
				  	<source src="android/files/<?php echo $file_name; ?>" type="audio/mpeg">
					Your browser does not support the audio element.
				</audio>
				<div class="speech-details">
					<b>Speech Details:</b><br>
					<table class="table-speech-details">
						<tr>
							<td>Speech Number</td>
							<td>: </td>
							<td><?php echo $speech_no; ?></td>
						</tr>
						<tr>
							<td>Author</td>
							<td>: </td>
							<td><?php echo $name; ?></td>
						</tr>
						<tr>
							<td>Language</td>
							<td>: </td>
							<td><?php echo $language; ?></td>
						</tr>
						<tr>
							<td>Category</td>
							<td>: </td>
							<td><?php echo $category; ?></td>
						</tr>
						<tr>
							<td>Speech Location</td>
							<td>: </td>
							<td><?php echo $location; ?></td>
						</tr>
						<tr>
							<td>Upload Time</td>
							<td>: </td>
							<td><?php echo $upload_time; ?></td>
						</tr>

						

						<?php if($admin){ ?>
							<tr>
								<td>Text</td>
								<td>: </td>
								<td><?php 
								if(file_exists("android/files/".$text_file_name)==1){
									echo "Click ";?> <a href="android/files/<?php echo $text_file_name; ?>" download="converted_text.txt">here</a> <?php echo " to download the text"; 
								}
								else{
									echo "Click ";?><a href="speech_to_sus.php?speech_no=<?php echo $speech_no; ?>">here</a> <?php echo " to start processing";
								}
								?></td>
							</tr>
							<tr>
								<td>Analysis</td>
								<td>: </td>
								<td><?php 
									$query = "SELECT suspicious FROM speech WHERE speech_no = ?";
									if($stmt = $con->prepare($query)){
										$stmt->bind_param("i", $speech_no);
										$stmt->execute();
										$stmt->bind_result($suspicious);
										$stmt->fetch();
										$stmt->close();

										$show = "Not Processed Yet";
										if($suspicious == 2) {$show = "Suspicious";}
										else if($suspicious == 1) {$show = "Non-Suspicious";}
										else if($suspicious == -1) {$show = "Analysis is Available for Bangla Only";}
										echo $show;
									}
								?></td>
							</tr>
						<?php } ?>
						
					</table>
				</div>
			</div>
		</div>
	</div>


	<!-- For ipad -->
	<div class="row show_speech-ipad">
		<div class="col-12 home-div">
			<div class="welcome-div">
				<center>
				<div class="welcome-header">
					<h2 style="margin-bottom: 0px"><?php echo $title; ?></h2>
					<p style="margin: 0px;"><?php echo $name.", ".$institution; ?></p>
				</div>
				</center>
				<p class="description-text"><b>Description:<br></b><span><?php echo $summary; ?></span></p>
				<audio controls controlsList="nodownload" style="width: 90%">
				  	<source src="android/files/<?php echo $file_name; ?>" type="audio/ogg">
				  	<source src="android/files/<?php echo $file_name; ?>" type="audio/mpeg">
					Your browser does not support the audio element.
				</audio>
				<div class="speech-details">
					<b>Speech Details:</b><br>
					<table class="table-speech-details">
						<tr>
							<td>Speech Number</td>
							<td>: </td>
							<td><?php echo $speech_no; ?></td>
						</tr>
						<tr>
							<td>Author</td>
							<td>: </td>
							<td><?php echo $name; ?></td>
						</tr>
						<tr>
							<td>Language</td>
							<td>: </td>
							<td><?php echo $language; ?></td>
						</tr>
						<tr>
							<td>Category</td>
							<td>: </td>
							<td><?php echo $category; ?></td>
						</tr>
						<tr>
							<td>Speech Location</td>
							<td>: </td>
							<td><?php echo $location; ?></td>
						</tr>
						<tr>
							<td>Upload Time</td>
							<td>: </td>
							<td><?php echo $upload_time; ?></td>
						</tr>

						

						<?php if($admin){ ?>
							<tr>
								<td>Text</td>
								<td>: </td>
								<td><?php 
								if(file_exists("android/files/".$text_file_name)==1){
									echo "Click ";?> <a href="android/files/<?php echo $text_file_name; ?>" download="converted_text.txt">here</a> <?php echo " to download the text"; 
								}
								else{
									echo "Click ";?><a href="speech_to_sus.php?speech_no=<?php echo $speech_no; ?>">here</a> <?php echo " to start processing";
								}
								?></td>
							</tr>
							<tr>
								<td>Analysis</td>
								<td>: </td>
								<td><?php 
									$query = "SELECT suspicious FROM speech WHERE speech_no = ?";
									if($stmt = $con->prepare($query)){
										$stmt->bind_param("i", $speech_no);
										$stmt->execute();
										$stmt->bind_result($suspicious);
										$stmt->fetch();
										$stmt->close();

										$show = "Not Processed Yet";
										if($suspicious == 2) {$show = "Suspicious";}
										else if($suspicious == 1) {$show = "Non-Suspicious";}
										else if($suspicious == -1) {$show = "Analysis is Available for Bangla Only";}
										echo $show;
									}
								?></td>
							</tr>
						<?php } ?>
						
					</table>
				</div>
			</div>
		</div>
	</div>


	<!-- For mobile -->
	<div class="row show_speech-mobile">
		<div class="col-12 home-div">
			<div class="welcome-div">
				<center>
				<div class="welcome-header">
					<h3 style="margin-bottom: 0px"><?php echo $title; ?></h3>
					<p style="margin: 0px;"><?php echo $name.", ".$institution; ?></p>
				</div>
				</center>
				<p class="description-text"><b>Description:<br></b><span><?php echo $summary; ?></span></p>
				<audio controls controlsList="nodownload" style="width: 90%">
				  	<source src="android/files/<?php echo $file_name; ?>" type="audio/ogg">
				  	<source src="android/files/<?php echo $file_name; ?>" type="audio/mpeg">
					Your browser does not support the audio element.
				</audio>
				<div class="speech-details">
					<b>Speech Details:</b><br>
					<table class="table-speech-details">
						<tr>
							<td>Speech Number</td>
							<td>: </td>
							<td><?php echo $speech_no; ?></td>
						</tr>
						<tr>
							<td>Author</td>
							<td>: </td>
							<td><?php echo $name; ?></td>
						</tr>
						<tr>
							<td>Language</td>
							<td>: </td>
							<td><?php echo $language; ?></td>
						</tr>
						<tr>
							<td>Category</td>
							<td>: </td>
							<td><?php echo $category; ?></td>
						</tr>
						<tr>
							<td>Speech Location</td>
							<td>: </td>
							<td><?php echo $location; ?></td>
						</tr>
						<tr>
							<td>Upload Time</td>
							<td>: </td>
							<td><?php echo $upload_time; ?></td>
						</tr>

						

						<?php if($admin){ ?>
							<tr>
								<td>Text</td>
								<td>: </td>
								<td><?php 
								if(file_exists("android/files/".$text_file_name)==1){
									echo "Click ";?> <a href="android/files/<?php echo $text_file_name; ?>" download="converted_text.txt">here</a> <?php echo " to download the text"; 
								}
								else{
									echo "Click ";?><a href="speech_to_sus.php?speech_no=<?php echo $speech_no; ?>">here</a> <?php echo " to start processing";
								}
								?></td>
							</tr>
							<tr>
								<td>Analysis</td>
								<td>: </td>
								<td><?php 
									$query = "SELECT suspicious FROM speech WHERE speech_no = ?";
									if($stmt = $con->prepare($query)){
										$stmt->bind_param("i", $speech_no);
										$stmt->execute();
										$stmt->bind_result($suspicious);
										$stmt->fetch();
										$stmt->close();

										$show = "Not Processed Yet";
										if($suspicious == 2) {$show = "Suspicious";}
										else if($suspicious == 1) {$show = "Non-Suspicious";}
										else if($suspicious == -1) {$show = "Analysis is Available for Bangla Only";}
										echo $show;
									}
								?></td>
							</tr>
						<?php } ?>
						
					</table>
				</div>
			</div>
		</div>
	</div>

</body>
</html>