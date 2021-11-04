<?php

require 'db-handler.php';

// Setup users table
$users = "CREATE TABLE users(
	username VARCHAR(255) NOT NULL ,
	email VARCHAR(255) NOT NULL ,
	pwd VARCHAR(255) NOT NULL ,
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
)";

// Setup news table
$news = "CREATE TABLE news(
	title VARCHAR(255) NOT NULL ,
	img VARCHAR(255) NOT NULL ,
	body VARCHAR(255) NOT NULL ,
	author VARCHAR(255) NOT NULL ,
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
)";


$tables = [
	["users", $users],
	["news", $news],
];

foreach ($tables as list($name, $table)) {
	if(mysqli_query($conn, $table))
		echo "Table ".$name." created successfully!<br>";
	else
		echo "ERROR: Could not execute $table.<br>" . mysqli_error($conn) . "<br>";
}