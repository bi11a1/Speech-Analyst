<?php
    // To know about which page is currently active
    // $curPage contains the currently active page, e.g: home
    $tmp = strtolower($_SERVER['REQUEST_URI']);
    $curPage="";
    for ($i=0; $i < strlen($tmp); $i++) { 
        if($tmp[$i]=="/") $curPage="";
        else if(substr($tmp, $i, 4)==".php") break;
        else $curPage=$curPage.$tmp[$i];
    }
?>

<!DOCTYPE html>
<html>
<html lang="en-US">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="css/header.css" type="text/css" rel="stylesheet">
	<link href="css/material.css" type="text/css" rel="stylesheet">
</head>
<body class="body" style="background-image: url('images/wp2561082.jpg'); background-repeat: no-repeat; background-size: cover;">
	<div class="row">
		<div class="col-1 laptop medium1">&nbsp</div>

		<div class="col-10 icon laptop medium1">
			<img class="header-img" src="images/icon.jpg" alt="Speech Analyst">
			<div class="header-option"><a href="login.php" class="option-link"><i class="fa fa-user" aria-hidden="true"> Admin</i></a></div>
			<div class="header-option"><a href="about.php" class="option-link"><i class="fa fa-question" aria-hidden="true"> About</i></a></div>
			<div class="header-option"><a href="search.php" class="option-link"><i class="fa fa-search" aria-hidden="true"> Search</i></a></div>
			<div class="header-option"><a href="home.php" class="option-link"><i class="fa fa-database" aria-hidden="true"> Repo</i></a></div>
			<div class="header-option"><a href="http://speechanalyst.com/" class="option-link"><i class="fa fa-home" aria-hidden="true"> Home</i></a></div>
		</div>

		<div class="col-12 icon laptop medium2">
			<img class="header-img" src="images/icon.jpg" alt="Speech Analyst">
			<div class="header-option"><a href="login.php" class="option-link">Admin</a></div>
			<div class="header-option"><a href="about.php" class="option-link">About</a></div>
			<div class="header-option"><a href="search.php" class="option-link">Search</a></div>
			<div class="header-option"><a href="home.php" class="option-link">Repo</a></div>
			<div class="header-option"><a href="http://speechanalyst.com/" class="option-link">Home</a></div>
		</div>

		<div class="col-12 mobile-ipad">
			<center>
			<img class="header-img" src="images/icon.jpg" alt="Speech Analyst">
			</center>
		</div>
		
		<div class="col-12 icon mobile-ipad">
			<center>
			<div class="header-option"><a href="http://speechanalyst.com/" class="option-link">Home</a></div>
			<div class="header-option"><a href="home.php" class="option-link">Repo</a></div>
			<div class="header-option"><a href="search.php" class="option-link">Search</a></div>
			<div class="header-option"><a href="about.php" class="option-link">About</a></div>
			<!-- <div class="header-option"><a href="contact.php" class="option-link">Contact</a></div> -->
			<div class="header-option"><a href="login.php" class="option-link">Admin</a></div>
			</center>
		</div>

		<div class="col-1 laptop medium1">&nbsp</div>
	</div>

</body>