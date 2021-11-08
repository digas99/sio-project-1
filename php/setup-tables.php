<?php

require 'db-handler.php';

// Setup users table
$users = "CREATE TABLE `admin`.`users`(
	username VARCHAR(255) NOT NULL ,
	email VARCHAR(255) NOT NULL ,
	pwd VARCHAR(255) NOT NULL ,
	pwd_sec VARCHAR(255) NOT NULL,
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
)";

// Setup news table
$news = "CREATE TABLE `admin`.`news`(
	title VARCHAR(255) NOT NULL ,
	img VARCHAR(255) NOT NULL ,
	body VARCHAR(255) NOT NULL ,
	author VARCHAR(255) NOT NULL ,
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
)";


mysqli_query($conn, $users);
mysqli_query($conn, $news);

// Add admin:admin user
$username = "admin";
$pwd = "admin";
$email = "admin";
$sql = "INSERT INTO users (username, email, pwd, pwd_sec) VALUES ('".$username."', '".$email."', '".$pwd."', '".password_hash($pwd, PASSWORD_DEFAULT)."');";
mysqli_query($conn, $sql);