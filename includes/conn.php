<?php
	ob_start();
	session_start();
	if ($con=mysqli_connect('localhost','root','','meet')) {
	}else{
		die("Error connecting to database");
	}
	date_default_timezone_set("Africa/Lagos");
?>