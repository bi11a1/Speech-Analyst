<?php
	include 'header.php';
	include 'android/db/db_connect.php';

	session_start();
	$_SESSION['access'] = 'none';

	$query = "SELECT name, speech_no, speech.user_id, title, language, category, location, upload_time
				FROM speech INNER JOIN user ON speech.user_id = user.user_id WHERE status = 0 ORDER BY speech_no DESC ";

	$data_size = 0;

	if($stmt = $con->prepare($query)){
		$stmt->execute();
		$stmt->bind_result($name, $speech_no, $user_id, $title, $language, $category, $location, $upload_time);

		$data_name = array();
		$data_speech_no = array();
		$data_user_id = array();
		$data_title = array();
		$data_language = array();
		$data_category = array();
		$data_location = array();
		$data_upload_time = array();

		while($stmt->fetch()){ 
			$data_name[] = $name;
			$data_speech_no[] = $speech_no;
			$data_user_id[] = $user_id;
			$data_title[] = $title;
			$data_language[] = $language;
			$data_category[] = $category;
			$data_location[] = $location;
			$data_upload_time[] = $upload_time;

			$data_size++;
		}

		$stmt->close();
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Speech Repository</title>
	<link href="css/home.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<!-- For laptop -->
	<div class="row home-laptop">
		<div class="col-1 space">&nbsp</div>

		<div class="col-2 sidebar" style="background-image: linear-gradient(to bottom right, lightblue, white);">
			<center>
				<div class="title"> Speech Repository </div>
			</center>

			<?php if($_SESSION['access'] == "all"){ ?>
			<div class="about-project">
				<i class="fa fa-angle-right"></i> <a href="pending_speech.php" class="about-link">Pending Speeches</a>
			</div>
			<?php } ?>

			<div class="about-project">
				<i class="fa fa-angle-right"></i> <a href="about.php" class="about-link">About this project</a>
			</div>
			<div class="about-option"><a href="about.php#what_is_it" class="about-link">- What is it?</a></div>
			<div class="about-option"><a href="about.php#how_does_it_work" class="about-link">- How does it work?</a></div>
			<div class="about-option"><a href="about.php#how_to_search" class="about-link">- How to search?</a></div>
			<div class="about-option"><a href="about.php#contact" class="about-link">- Contact</a></div>
		</div>
		<div class="col-8 home-div" style="background-image: linear-gradient(to bottom right, #eafaff, #ffffff);">
			<div class="audio-div">
				<h2 class="welcome-header">Pending Speeches</h2>
				<table class="table-style-three">
					<thead>
					<tr>
						<th>Serial</th>
						<th>Title</th>
						<th>Language</th>
						<th>Category</th>
						<th>Location</th>
						<th>Author</th>
						<th style="width: 110px">Time</th>
					</tr>
					</thead>
					<tbody>
					<?php 
						for($i=0; $i<$data_size; $i++){
						$show_speech_location = "show_pending_speech.php?speech_no=".$data_speech_no[$i];
						?>

						<tr onclick=" document.location = '<?php echo $show_speech_location; ?>'; ">
							<td><?php echo $data_speech_no[$i]; ?></td>
							<td><?php echo $data_title[$i]; ?></td>
							<td><?php echo $data_language[$i]; ?></td>
							<td><?php echo $data_category[$i]; ?></td>
							<td><?php echo $data_location[$i]; ?></td>
							<td><?php echo $data_name[$i]; ?></td>
							<td><?php echo $data_upload_time[$i]; ?></td>
						</tr>

						<?php 
						}
					 ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="col-1">&nbsp</div>
	</div>


	<!-- For mini-laptop -->
	<div class="row home-mini-laptop">
		<div class="col-3 sidebar" style="background-image: linear-gradient(to bottom right, lightblue, white);">
			<center>
				<div class="title"> Speech Repository </div>
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
			<div class="audio-div">
				<h2 class="welcome-header">Pending Speeches</h2>
				<table class="table-style-three">
					<thead>
					<tr>
						<th>Serial</th>
						<th>Title</th>
						<th>Language</th>
						<th>Category</th>
						<th>Location</th>
						<th>Author</th>
					</tr>
					</thead>
					<tbody>
					<?php 
						for($i=0; $i<$data_size; $i++){
						$show_speech_location = "show_pending_speech.php?speech_no=".$data_speech_no[$i];
						?>

						<tr onclick=" document.location = '<?php echo $show_speech_location; ?>'; ">
							<td><?php echo $data_speech_no[$i]; ?></td>
							<td><?php echo $data_title[$i]; ?></td>
							<td><?php echo $data_language[$i]; ?></td>
							<td><?php echo $data_category[$i]; ?></td>
							<td><?php echo $data_location[$i]; ?></td>
							<td><?php echo $data_name[$i]; ?></td>
						</tr>
						
						<?php 
						}
					 ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- For ipad -->
	<div class="row home-ipad">
		<div class="col-12 home-div">
			<div class="audio-div">
				<h3 class="welcome-header">Pending Speeches</h3>
				<table class="table-style-three">
					<thead>
					<tr>
						<th>Serial</th>
						<th>Title</th>
						<th>Category</th>
						<th>Author</th>
					</tr>
					</thead>
					<tbody>
					<?php 
						for($i=0; $i<$data_size; $i++){
						$show_speech_location = "show_pending_speech.php?speech_no=".$data_speech_no[$i];
						?>

						<tr onclick=" document.location = '<?php echo $show_speech_location; ?>'; ">
							<td><?php echo $data_speech_no[$i]; ?></td>
							<td><?php echo $data_title[$i]; ?></td>
							<td><?php echo $data_category[$i]; ?></td>
							<td><?php echo $data_name[$i]; ?></td>
						</tr>
						
						<?php 
						}
					 ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- For mobile -->
	<div class="row home-mobile">
		<div class="col-12 home-div">
			<div class="audio-div">
				<h4 class="welcome-header">Pending Speeches</h4>
				<table class="table-style-three">
					<thead>
					<tr>
						<th>Serial</th>
						<th>Title</th>
						<th>Author</th>
					</tr>
					</thead>
					<tbody>
					<?php 
						for($i=0; $i<$data_size; $i++){
						$show_speech_location = "show_pending_speech.php?speech_no=".$data_speech_no[$i];
						?>

						<tr onclick=" document.location = '<?php echo $show_speech_location; ?>'; ">
							<td><?php echo $data_speech_no[$i]; ?></td>
							<td><?php echo $data_title[$i]; ?></td>
							<td><?php echo $data_name[$i]; ?></td>
						</tr>
						
						<?php 
						}
					 ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</body>
</html>