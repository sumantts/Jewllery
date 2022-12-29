<?php
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'jewellery_v2';
	
	$mysqli = new mysqli($host, $username, $password, $dbname);

	// Check connection
	if ($mysqli -> connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
		exit();
	}else{
		//echo "Connected Successfully";
	}
	
	$con = mysqli_connect($host, $username, $password, $dbname);
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
	}
	session_start();	
		 
?>
