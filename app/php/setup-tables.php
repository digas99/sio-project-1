<?php

require 'db-handler.php';

// Setup users table
$sql = "CREATE TABLE users(
	username VARCHAR(255) NOT NULL ,
	email VARCHAR(255) NOT NULL ,
	pwd VARCHAR(255) NOT NULL ,
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
)";

if(mysqli_query($conn, $sql))
	echo "Table users created successfully!<br>";
else
	echo "ERROR: Could not execute $sql.<br>" . mysqli_error($conn);

$sql = "CREATE TABLE news(
	title VARCHAR(255) NOT NULL ,
	img VARCHAR(255) NOT NULL ,
	body VARCHAR(255) NOT NULL ,
	author VARCHAR(255) NOT NULL ,
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
)";

// Setup news table
if(mysqli_query($conn, $sql))
	echo "Table news created successfully!<br>";
else
	echo "ERROR: Could not execute $sql.<br> " . mysqli_error($conn);
