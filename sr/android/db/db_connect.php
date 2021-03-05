<?php

define('DB_USER', "bn_wordpress");
define('DB_PASSWORD', "d05385e674");
define('DB_DATABASE', "bitnami_wordpress");
define('DB_SERVER', "localhost");
 
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
 
// Check connection
if(mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>