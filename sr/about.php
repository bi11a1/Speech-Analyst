<?php
	include 'header.php';
	session_start();
	$_SESSION['access'] = 'none';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Speech Analyst</title>
	<link href="css/about.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<!-- For laptop -->
	<div class="row home-laptop">
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
			<div>
				<h2 class="about-header" id="what_is_it">What is it?</h2>
				<p class="about-description">Welcome to speech analyst. It contains speeches from various places. Here you can find hundreds of speeches from real life. The speeches are recorded from various conference or mosque or important fields which can be useful for everyone. You will also find various study material on different subjects. You can search speeches from the existings speeches.</p>

				<h2 class="about-header" id="how_does_it_work">How does it work?</h2>
				<p class="about-description">First it records speeches using an android <a href="https://speechanalyst.com/SA.apk" download>app</a>. Then the app send the speech information to the server. After validating the speech it is approved and then the speech will be avaible. The speeches are recorded from various conference or mosque or important fields which can be useful for everyone. So if you have missed any conference you can find the recordings here. You will also find various study material on different subjects. You can search speeches from the existings speeches.</p>
				<h2 class="about-header" id="how_to_search">How to search?</h2>
				<p class="about-description">Here you can search through speeches according to,<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>1)</b> Language (e.g: Bengali, English)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>2)</b> Location (e.g: Dhaka, Chittagong)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>3)</b> Category (e.g: Conference, Religion)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>4)</b> Person Name (e.g: Rahim, Karim)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>5)</b> Institution (e.g: BUET, CUET)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>6)</b> Speech No. (e.g: 124, 388)<br></p>
				<h2 class="about-header" id="contact">Contact</h2>
				For any suggestions <a href="https://speechanalyst.com/contact/">contact</a> us via our email address or phone number given in the website.</p>
			</div>
		</div>

		<div class="col-1">&nbsp</div>
	</div>

	<!-- For mini-laptop -->
	<div class="row home-mini-laptop">
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
			<div>
				<h2 class="about-header">What is it?</h2>
				<p class="about-description">Welcome to speech analyst. It contains speeches from various places. Here you can find hundreds of speeches from real life. The speeches are recorded from various conference or mosque or important fields which can be useful for everyone. You will also find various study material on different subjects. You can search speeches from the existings speeches.</p>

				<h2 class="about-header">How does it work?</h2>
				<p class="about-description">First it records speeches using an android <a href="https://speechanalyst.com/SA.apk" download>app</a>. Then the app send the speech information to the server. After validating the speech it is approved and then the speech will be avaible. The speeches are recorded from various conference or mosque or important fields which can be useful for everyone. So if you have missed any conference you can find the recordings here. You will also find various study material on different subjects. You can search speeches from the existings speeches.</p>
				<h2 class="about-header">How to search?</h2>
				<p class="about-description">Here you can search through speeches according to,<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>1)</b> Language (e.g: Bengali, English)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>2)</b> Location (e.g: Dhaka, Chittagong)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>3)</b> Category (e.g: Conference, Religion)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>4)</b> Person Name (e.g: Rahim, Karim)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>5)</b> Institution (e.g: BUET, CUET)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>6)</b> Speech No. (e.g: 124, 388)<br></p>
				<h2 class="about-header">Contact</h2>
				For any suggestions <a href="https://speechanalyst.com/contact/">contact</a> us via our email address or phone number given in the website.</p>
			</div>
		</div>
	</div>

	<!-- For ipad -->
	<div class="row home-ipad">
		<div class="col-12 home-div">
			<div>
				<h3 class="about-header">What is it?</h3>
				<p class="about-description">Welcome to speech repository. It contains speeches from various places. Here you can find hundreds of speeches from real life. The speeches are recorded from various conference or mosque or important fields which can be useful for everyone. You will also find various study material on different subjects. You can search speeches from the existings speeches.</p>

				<h3 class="about-header">How does it work?</h3>
				<p class="about-description">First it records speeches using an android <a href="https://speechanalyst.com/SA.apk" download>app</a>. Then the app send the speech information to the server. After validating the speech it is approved and then the speech will be avaible. The speeches are recorded from various conference or mosque or important fields which can be useful for everyone. So if you have missed any conference you can find the recordings here. You will also find various study material on different subjects. You can search speeches from the existings speeches.</p>
				<h3 class="about-header">How to search?</h3>
				<p class="about-description">Here you can search through speeches according to,<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>1)</b> Language (e.g: Bengali, English)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>2)</b> Location (e.g: Dhaka, Chittagong)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>3)</b> Category (e.g: Conference, Religion)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>4)</b> Person Name (e.g: Rahim, Karim)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>5)</b> Institution (e.g: BUET, CUET)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>6)</b> Speech No. (e.g: 124, 388)<br></p>
				<h3 class="about-header">Contact</h3>
				For any suggestions <a href="https://speechanalyst.com/contact/">contact</a> us via our email address or phone number given in the website.</p>
			</div>
		</div>
	</div>

	<!-- For mobile -->
	<div class="row home-mobile">
		<div class="col-12 home-div">
			<div>
				<h3 class="about-header">What is it?</h3>
				<p class="about-description">Welcome to speech analyst. It contains speeches from various places. Here you can find hundreds of speeches from real life. The speeches are recorded from various conference or mosque or important fields which can be useful for everyone. You will also find various study material on different subjects. You can search speeches from the existings speeches.</p>

				<h3 class="about-header">How does it work?</h3>
				<p class="about-description">First it records speeches using an android <a href="https://speechanalyst.com/SA.apk" download>app</a>. Then the app send the speech information to the server. After validating the speech it is approved and then the speech will be avaible. The speeches are recorded from various conference or mosque or important fields which can be useful for everyone. So if you have missed any conference you can find the recordings here. You will also find various study material on different subjects. You can search speeches from the existings speeches.</p>
				<h3 class="about-header">How to search?</h3>
				<p class="about-description">Here you can search through speeches according to,<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>1)</b> Language (e.g: Bengali, English)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>2)</b> Location (e.g: Dhaka, Chittagong)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>3)</b> Category (e.g: Conference, Religion)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>4)</b> Person Name (e.g: Rahim, Karim)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>5)</b> Institution (e.g: BUET, CUET)<br>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>6)</b> Speech No. (e.g: 124, 388)<br></p>
				<h3 class="about-header">Contact</h3>
				For any suggestions <a href="https://speechanalyst.com/contact/">contact</a> us via our email address or phone number given in the website.</p>
			</div>
		</div>
	</div>
</body>
</html>