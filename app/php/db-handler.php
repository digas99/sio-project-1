<?php

$servername = "localhost";

// fill in database values
$db_username = "admin";
$db_password = "2W3GlejAr3sd2KIx";
$db_name = "admin";

$conn = mysqli_connect($servername, $db_username, $db_password, $db_name);

// check for db connection failure
if (!$conn) {
	// kill the connection
	die("Connection failed: ".mysqli_connect_error());
}