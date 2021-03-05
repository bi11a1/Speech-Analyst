<?php
	include 'android/db/db_connect.php';
	include 'header.php';
	session_start();
	$_SESSION['access'] = 'none';

	$language = $location = $category = $author_name = $institution = "";
	$speech_no = 0;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST['language'])){
			$language = $_POST['language'];
			if($language == "All") $language = "";
		}
		if(isset($_POST['location'])){
			$location = $_POST['location'];
		}
		if(isset($_POST['category'])){
			$category = $_POST['category'];
			if($category == "All") $category = "";
		}
  		if (isset($_POST["author_name"])) {
  			$author_name = $_POST["author_name"];
  		}
		if(isset($_POST['institution'])){
			$institution = $_POST['institution'];
		}
		if(isset($_POST['speech_no'])){
			$speech_no = $_POST['speech_no'];
		}
		else{
			$speech_no = 0;
		}
  	}

  	$language = '%'.$language.'%';
  	$location = '%'.$location.'%';
  	$category = '%'.$category.'%';
  	$author_name = '%'.$author_name.'%';
  	$institution = '%'.$institution.'%';

  	if($speech_no == 0){
  		$query = "SELECT name, speech_no, speech.user_id, title, language, category, location, upload_time
			FROM speech INNER JOIN user ON speech.user_id = user.user_id
			WHERE language LIKE ? and location LIKE ? and category LIKE ? and name LIKE ? and institution LIKE ? ORDER BY speech_no DESC";
  	}
  	else{
  		$query = "SELECT name, speech_no, speech.user_id, title, language, category, location, upload_time
			FROM speech INNER JOIN user ON speech.user_id = user.user_id
			WHERE language LIKE ? and location LIKE ? and category LIKE ? and name LIKE ? and institution LIKE ? and speech_no = ? ORDER BY speech_no DESC";
  	}

  	/*if($speech_no == 0){
  		$query = "SELECT name, speech_no, speech.user_id, title, language, category, actual_location, upload_time
			FROM speech INNER JOIN user ON speech.user_id = user.user_id
			WHERE status = 1 and language LIKE ? and actual_location LIKE ? and category LIKE ? and name LIKE ? and institution LIKE ? ORDER BY speech_no DESC";
  	}
  	else{
  		$query = "SELECT name, speech_no, speech.user_id, title, language, category, actual_location, upload_time
			FROM speech INNER JOIN user ON speech.user_id = user.user_id
			WHERE status = 1 and language LIKE ? and actual_location LIKE ? and category LIKE ? and name LIKE ? and institution LIKE ? and speech_no = ? ORDER BY speech_no DESC";
  	}*/

	

	$data_size = 0;

	if($stmt = $con->prepare($query)){
		
		if($speech_no == 0) $stmt->bind_param("sssss", $language, $location, $category, $author_name, $institution);
		else $stmt->bind_param("sssssi", $language, $location, $category, $author_name, $institution, $speech_no);
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

	/*for ($i=0; $i < $data_size; $i++) { 
		echo "Name = ", $data_name[$i], " No = ", $data_speech_no[$i], " id = ", $data_user_id[$i], " title = ", $data_title[$i], " language = ", $data_language[$i],  " category = ", $data_category[$i],  " location = ", $data_location[$i],  " time = ", $data_upload_time[$i], "<br><br>";
	}*/

	$page_limit = 15;
	$page = 1;
	$next_invalid = 0;
	$prev_invalid = 0;
	if(isset($_GET['page'])) $page = $_GET['page'];
	if($page<=0 || $page_limit*($page-1) > $data_size) $page = 1;

	$next_page = $page+1;
	if($next_page<=0 || $page_limit*($next_page-1) > $data_size){
		$next_page = 1;
		$next_invalid = 1;
	}

	$prev_page = $page-1;
	if($prev_page<=0 || $page_limit*($prev_page-1) > $data_size){
		$prev_page = 1;
		$prev_invalid = 1;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Result</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/search_result.css">
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
		        <form id="search_form" action="search_result.php#search_result" method="post">
		        	<div class="category"><i class="fa fa-language"></i> &nbspLanguage:</div>
					<select name="language" class="text">
						<option value="All" <?php if($_POST['language'] == "All") echo "selected";?>>All</option>
						<option value="Bengali" <?php if($_POST['language'] == "Bengali") echo "selected";?>>Bengali</option>
						<option value="English" <?php if($_POST['language'] == "English") echo "selected";?>>English</option>
						<option value="Arabic" <?php if($_POST['language'] == "Arabic") echo "selected";?>>Arabic</option>
					</select>

		        	<div class="category"><i class="fa fa-map-marker"></i> &nbspLocation:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong" name="location"
						value="<?php echo($_POST['location']); ?>">

					<div class="category"><i class="fa fa-list-alt"></i> &nbspCategory:</div>
					<select name="category" class="text">
						<option value="All" <?php if($_POST['category'] == "All") echo "selected";?>>All</option>
						<option value="Education" <?php if($_POST['category'] == "Education") echo "selected";?>>Education</option>
						<option value="Conference" <?php if($_POST['category'] == "Conference") echo "selected";?>>Conference</option>
						<option value="Religion" <?php if($_POST['category'] == "Religion") echo "selected";?>>Religion</option>
						<option value="Job Interview" <?php if($_POST['category'] == "Job Interview") echo "selected";?>>Job Interview</option>
					</select>


		        	<div class="category"><i class="fa fa-user"></i> &nbspAuthor Name:</div>
					<input type="text" class="text" placeholder="e.g: Rahim" name="author_name"
						value="<?php echo($_POST['author_name']); ?>">

		        	<div class="category"><i class="fa fa-institution"></i> &nbspInstitution:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong University of Engineering and Technology" name="institution" value="<?php echo($_POST['institution']); ?>">

		        	<div class="category"><i class="fa fa-comments"></i> &nbspSpeech No:</div>
					<input type="number" class="text" placeholder="e.g: 27" name="speech_no"
						value="<?php echo($_POST['speech_no']); ?>">

					<input type="submit" class="button" id="form_btn" value="Search" name="submit">
				</form>
			</div>
			</center>
			<div class="audio-div">
				<h2 class="welcome-header" id="search_result">Search Result</h2>
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
						for($i=($page-1)*$page_limit; $i<$page*$page_limit && $i<$data_size; $i++){
						$show_speech_location = "show_speech.php?speech_no=".$data_speech_no[$i];
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
				<center>
				<?php if($prev_invalid == 0){ ?>
				<input type="submit" form="search_form" formaction= "search_result.php#search_result?page=<?php echo $prev_page; ?>" value="<" title="Prev Page"/>
				<?php } ?>
				&nbsp&nbsp
				<?php if($next_invalid == 0){ ?>
				<input type="submit" form="search_form" formaction="search_result.php?page=<?php echo $next_page; ?>" value=">" title="Next Page"/>
				<?php } ?>
				</center>
			</div>
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
		        <form id="search_form" action="search_result.php" method="post">
		        	<div class="category"><i class="fa fa-language"></i> &nbspLanguage:</div>
					<select name="language" class="text">
						<option value="All" <?php if($_POST['language'] == "All") echo "selected";?>>All</option>
						<option value="Bengali" <?php if($_POST['language'] == "Bengali") echo "selected";?>>Bengali</option>
						<option value="English" <?php if($_POST['language'] == "English") echo "selected";?>>English</option>
						<option value="Arabic" <?php if($_POST['language'] == "Arabic") echo "selected";?>>Arabic</option>
					</select>

		        	<div class="category"><i class="fa fa-map-marker"></i> &nbspLocation:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong" name="location"
						value="<?php echo($_POST['location']); ?>">

					<div class="category"><i class="fa fa-list-alt"></i> &nbspCategory:</div>
					<select name="category" class="text">
						<option value="All" <?php if($_POST['category'] == "All") echo "selected";?>>All</option>
						<option value="Education" <?php if($_POST['category'] == "Education") echo "selected";?>>Education</option>
						<option value="Conference" <?php if($_POST['category'] == "Conference") echo "selected";?>>Conference</option>
						<option value="Religion" <?php if($_POST['category'] == "Religion") echo "selected";?>>Religion</option>
						<option value="Job Interview" <?php if($_POST['category'] == "Job Interview") echo "selected";?>>Job Interview</option>
					</select>


		        	<div class="category"><i class="fa fa-user"></i> &nbspAuthor Name:</div>
					<input type="text" class="text" placeholder="e.g: Rahim" name="author_name"
						value="<?php echo($_POST['author_name']); ?>">

		        	<div class="category"><i class="fa fa-institution"></i> &nbspInstitution:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong University of Engineering and Technology" name="institution" value="<?php echo($_POST['institution']); ?>">

		        	<div class="category"><i class="fa fa-comments"></i> &nbspSpeech No:</div>
					<input type="number" class="text" placeholder="e.g: 27" name="speech_no"
						value="<?php echo($_POST['speech_no']); ?>">

					<input type="submit" class="button" id="form_btn" value="Search" name="submit">
				</form>
			</div>
			</center>
			<div class="audio-div">
				<h2 class="welcome-header">Search Result</h2>
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
						for($i=($page-1)*$page_limit; $i<$page*$page_limit && $i<$data_size; $i++){
						$show_speech_location = "show_speech.php?speech_no=".$data_speech_no[$i];
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
				<center>
				<?php if($prev_invalid == 0){ ?>
				<input type="submit" form="search_form" formaction= "search_result.php?page=<?php echo $prev_page; ?>" value="<" title="Prev Page"/>
				<?php } ?>
				&nbsp&nbsp
				<?php if($next_invalid == 0){ ?>
				<input type="submit" form="search_form" formaction="search_result.php?page=<?php echo $next_page; ?>" value=">" title="Next Page"/>
				<?php } ?>
				</center>
			</div>
	    </div>
	</div>

	<!-- For ipad -->
	<div class="row search-ipad">
	    <div class="col-12 search-div"><br>
	    	<center>
	    	<h2 style="margin: 10px 0 15px 0">Search for Speeches</h2>

	    	<div style="width: 90%; display: inline-block;">
		        <form id="search_form" action="search_result.php" method="post">
		        	<div class="category"><i class="fa fa-language"></i> &nbspLanguage:</div>
					<select name="language" class="text">
						<option value="All" <?php if($_POST['language'] == "All") echo "selected";?>>All</option>
						<option value="Bengali" <?php if($_POST['language'] == "Bengali") echo "selected";?>>Bengali</option>
						<option value="English" <?php if($_POST['language'] == "English") echo "selected";?>>English</option>
						<option value="Arabic" <?php if($_POST['language'] == "Arabic") echo "selected";?>>Arabic</option>
					</select>

		        	<div class="category"><i class="fa fa-map-marker"></i> &nbspLocation:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong" name="location"
						value="<?php echo($_POST['location']); ?>">

					<div class="category"><i class="fa fa-list-alt"></i> &nbspCategory:</div>
					<select name="category" class="text">
						<option value="All" <?php if($_POST['category'] == "All") echo "selected";?>>All</option>
						<option value="Education" <?php if($_POST['category'] == "Education") echo "selected";?>>Education</option>
						<option value="Conference" <?php if($_POST['category'] == "Conference") echo "selected";?>>Conference</option>
						<option value="Religion" <?php if($_POST['category'] == "Religion") echo "selected";?>>Religion</option>
						<option value="Job Interview" <?php if($_POST['category'] == "Job Interview") echo "selected";?>>Job Interview</option>
					</select>


		        	<div class="category"><i class="fa fa-user"></i> &nbspAuthor Name:</div>
					<input type="text" class="text" placeholder="e.g: Rahim" name="author_name"
						value="<?php echo($_POST['author_name']); ?>">

		        	<div class="category"><i class="fa fa-institution"></i> &nbspInstitution:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong University of Engineering and Technology" name="institution" value="<?php echo($_POST['institution']); ?>">

		        	<div class="category"><i class="fa fa-comments"></i> &nbspSpeech No:</div>
					<input type="number" class="text" placeholder="e.g: 27" name="speech_no"
						value="<?php echo($_POST['speech_no']); ?>">

					<input type="submit" class="button" id="form_btn" value="Search" name="submit">
				</form>
			</div>
			</center>
			<div class="audio-div">
				<h2 class="welcome-header">Search Result</h2>
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
						for($i=($page-1)*$page_limit; $i<$page*$page_limit && $i<$data_size; $i++){
						$show_speech_location = "show_speech.php?speech_no=".$data_speech_no[$i];
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
				<center>
				<?php if($prev_invalid == 0){ ?>
				<input type="submit" form="search_form" formaction= "search_result.php?page=<?php echo $prev_page; ?>" value="<" title="Prev Page"/>
				<?php } ?>
				&nbsp&nbsp
				<?php if($next_invalid == 0){ ?>
				<input type="submit" form="search_form" formaction="search_result.php?page=<?php echo $next_page; ?>" value=">" title="Next Page"/>
				<?php } ?>
				</center>
			</div>
	    </div>
	</div>

	<!-- For mobile -->
	<div class="row search-mobile">
	    <div class="col-12 search-div"><br>
	    	<center>
	    	<h3 style="margin: 5px 0 10px 0">Search for Speeches</h3>

	    	<div style="width: 90%; display: inline-block;">
		        <form id="search_form" action="search_result.php" method="post">
		        	<div class="category"><i class="fa fa-language"></i> &nbspLanguage:</div>
					<select name="language" class="text">
						<option value="All" <?php if($_POST['language'] == "All") echo "selected";?>>All</option>
						<option value="Bengali" <?php if($_POST['language'] == "Bengali") echo "selected";?>>Bengali</option>
						<option value="English" <?php if($_POST['language'] == "English") echo "selected";?>>English</option>
						<option value="Arabic" <?php if($_POST['language'] == "Arabic") echo "selected";?>>Arabic</option>
					</select>

		        	<div class="category"><i class="fa fa-map-marker"></i> &nbspLocation:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong" name="location"
						value="<?php echo($_POST['location']); ?>">

					<div class="category"><i class="fa fa-list-alt"></i> &nbspCategory:</div>
					<select name="category" class="text">
						<option value="All" <?php if($_POST['category'] == "All") echo "selected";?>>All</option>
						<option value="Education" <?php if($_POST['category'] == "Education") echo "selected";?>>Education</option>
						<option value="Conference" <?php if($_POST['category'] == "Conference") echo "selected";?>>Conference</option>
						<option value="Religion" <?php if($_POST['category'] == "Religion") echo "selected";?>>Religion</option>
						<option value="Job Interview" <?php if($_POST['category'] == "Job Interview") echo "selected";?>>Job Interview</option>
					</select>


		        	<div class="category"><i class="fa fa-user"></i> &nbspAuthor Name:</div>
					<input type="text" class="text" placeholder="e.g: Rahim" name="author_name"
						value="<?php echo($_POST['author_name']); ?>">

		        	<div class="category"><i class="fa fa-institution"></i> &nbspInstitution:</div>
					<input type="text" class="text" placeholder="e.g: Chittagong University of Engineering and Technology" name="institution" value="<?php echo($_POST['institution']); ?>">

		        	<div class="category"><i class="fa fa-comments"></i> &nbspSpeech No:</div>
					<input type="number" class="text" placeholder="e.g: 27" name="speech_no"
						value="<?php echo($_POST['speech_no']); ?>">

					<input type="submit" class="button" id="form_btn" value="Search" name="submit">
				</form>
			</div>
			</center>
			<div class="audio-div">
				<h2 class="welcome-header">Search Result</h2>
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
						for($i=($page-1)*$page_limit; $i<$page*$page_limit && $i<$data_size; $i++){
						$show_speech_location = "show_speech.php?speech_no=".$data_speech_no[$i];
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
				<center>
				<?php if($prev_invalid == 0){ ?>
				<input type="submit" form="search_form" formaction= "search_result.php?page=<?php echo $prev_page; ?>" value="<" title="Prev Page"/>
				<?php } ?>
				&nbsp&nbsp
				<?php if($next_invalid == 0){ ?>
				<input type="submit" form="search_form" formaction="search_result.php?page=<?php echo $next_page; ?>" value=">" title="Next Page"/>
				<?php } ?>
				</center>
			</div>
	    </div>
	</div>
</body>
</html>