<?php
	include 'header.php';
	session_start();
	$_SESSION['access'] = 'none';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/search.css">
</head>
<body>
	<!-- For laptop -->
	<div class="row search-laptop">
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
	    <div class="col-8 search-div" style="background-image: linear-gradient(to bottom right, #eafaff, #ffffff);"><br>
	    	<center>
	    	<h1 style="margin: 10px 0 15px 0">Search for Speeches</h1>

	    	<div style="width: 65%; display: inline-block;">
		        <form action="search_result.php#search_result" method="post">
		        	<div class="category"><i class="fa fa-language"></i> &nbspLanguage:</div>
					<select name="language" class="text">
						<option value="All">All</option>
						<option value="Bengali">Bengali</option>
						<option value="English">English</option>
						<option value="Arabic">Arabic</option>
					</select>

		        	<div class="category"><i class="fa fa-map-marker"></i> &nbspLocation:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong" name="location">

					<div class="category"><i class="fa fa-list-alt"></i> &nbspCategory:</div>
					<select name="category" class="text">
						<option value="All">All</option>
						<option value="Education">Education</option>
						<option value="Conference">Conference</option>
						<option value="Religion">Religion</option>
						<option value="Job Interview">Job Interview</option>
					</select>


		        	<div class="category"><i class="fa fa-user"></i> &nbspAuthor Name:</div>
					<input type="text" class="text" placeholder="e.g: Rahim" name="author_name">

		        	<div class="category"><i class="fa fa-institution"></i> &nbspInstitution:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong University of Engineering and Technology" name="institution">

		        	<div class="category"><i class="fa fa-comments"></i> &nbspSpeech No:</div>
					<input type="number" class="text" placeholder="e.g: 27" name="speech_no">

					<input type="submit" class="button" id="reg_btn" value="Search" name="submit">
				</form>
			</div>
			</center>
	    </div>

	    <div class="col-1 space">&nbsp</div>
	</div>

	<!-- For mini-laptop -->
	<div class="row search-mini-laptop">
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
	    <div class="col-9 search-div" style="background-image: linear-gradient(to bottom right, #eafaff, #ffffff);"><br>
	    	<center>
	    	<h1 style="margin: 10px 0 15px 0">Search for Speeches</h1>

	    	<div style="width: 80%; display: inline-block;">
		        <form action="search_result.php#search_result" method="post">
		        	<div class="category"><i class="fa fa-language"></i> &nbspLanguage:</div>
					<select name="language" class="text">
						<option value="All">All</option>
						<option value="Bengali">Bengali</option>
						<option value="English">English</option>
						<option value="Arabic">Arabic</option>
					</select>

		        	<div class="category"><i class="fa fa-map-marker"></i> &nbspLocation:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong" name="location">

					<div class="category"><i class="fa fa-list-alt"></i> &nbspCategory:</div>
					<select name="category" class="text">
						<option value="All">All</option>
						<option value="Education">Education</option>
						<option value="Conference">Conference</option>
						<option value="Religion">Religion</option>
						<option value="Job Interview">Job Interview</option>
					</select>


		        	<div class="category"><i class="fa fa-user"></i> &nbspAuthor Name:</div>
					<input type="text" class="text" placeholder="e.g: Rahim" name="author_name">

		        	<div class="category"><i class="fa fa-institution"></i> &nbspInstitution:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong University of Engineering and Technology" name="institution">

		        	<div class="category"><i class="fa fa-comments"></i> &nbspSpeech No:</div>
					<input type="number" class="text" placeholder="e.g: 27" name="speech_no">

					<input type="submit" class="button" id="reg_btn" value="Search" name="submit">
				</form>
			</div>
			</center>
	    </div>
	</div>

	<!-- For ipad -->
	<div class="row search-ipad">
	    <div class="col-12 search-div"><br>
	    	<center>
	    	<h2 style="margin: 10px 0 15px 0">Search for Speeches</h2>

	    	<div style="width: 90%; display: inline-block;">
		        <form action="search_result.php#search_result" method="post">
		        	<div class="category"><i class="fa fa-language"></i> &nbspLanguage:</div>
					<select name="language" class="text">
						<option value="All">All</option>
						<option value="Bengali">Bengali</option>
						<option value="English">English</option>
						<option value="Arabic">Arabic</option>
					</select>

		        	<div class="category"><i class="fa fa-map-marker"></i> &nbspLocation:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong" name="location">

					<div class="category"><i class="fa fa-list-alt"></i> &nbspCategory:</div>
					<select name="category" class="text">
						<option value="All">All</option>
						<option value="Education">Education</option>
						<option value="Conference">Conference</option>
						<option value="Religion">Religion</option>
						<option value="Job Interview">Job Interview</option>
					</select>


		        	<div class="category"><i class="fa fa-user"></i> &nbspAuthor Name:</div>
					<input type="text" class="text" placeholder="e.g: Rahim" name="author_name">

		        	<div class="category"><i class="fa fa-institution"></i> &nbspInstitution:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong University of Engineering and Technology" name="institution">

		        	<div class="category"><i class="fa fa-comments"></i> &nbspSpeech No:</div>
					<input type="number" class="text" placeholder="e.g: 27" name="speech_no">

					<input type="submit" class="button" id="reg_btn" value="Search" name="submit">
				</form>
			</div>
			</center>
	    </div>
	</div>

	<!-- For mobile -->
	<div class="row search-mobile">
		<div class="col-12 search-div"><br>
	    	<center>
	    	<h3 style="margin: 5px 0 10px 0">Search for Speeches</h3>

	    	<div style="width: 90%; display: inline-block;">
		        <form action="search_result.php#search_result" method="post">
		        	<div class="category"><i class="fa fa-language"></i> &nbspLanguage:</div>
					<select name="language" class="text">
						<option value="All">All</option>
						<option value="Bengali">Bengali</option>
						<option value="English">English</option>
						<option value="Arabic">Arabic</option>
					</select>

		        	<div class="category"><i class="fa fa-map-marker"></i> &nbspLocation:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong" name="location">

					<div class="category"><i class="fa fa-list-alt"></i> &nbspCategory:</div>
					<select name="category" class="text">
						<option value="All">All</option>
						<option value="Education">Education</option>
						<option value="Conference">Conference</option>
						<option value="Religion">Religion</option>
						<option value="Job Interview">Job Interview</option>
					</select>


		        	<div class="category"><i class="fa fa-user"></i> &nbspAuthor Name:</div>
					<input type="text" class="text" placeholder="e.g: Rahim" name="author_name">

		        	<div class="category"><i class="fa fa-institution"></i> &nbspInstitution:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong University of Engineering and Technology" name="institution">

		        	<div class="category"><i class="fa fa-comments"></i> &nbspSpeech No:</div>
					<input type="number" class="text" placeholder="e.g: 38" name="speech_no">

					<input type="submit" class="button" id="reg_btn" value="Search" name="submit">
				</form>
			</div>
			</center>
	    </div>
	</div>

</body>
</html>