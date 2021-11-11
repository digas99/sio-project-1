<?php

require 'db-handler.php';

// Setup users table
$users = "CREATE TABLE `admin`.`users`(
	username VARCHAR(255) NOT NULL ,
	email VARCHAR(255) NOT NULL ,
	pwd VARCHAR(255) NOT NULL ,
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
)";

// Setup users table secure
$users_sec = "CREATE TABLE `admin`.`users_sec`(
	username VARCHAR(255) NOT NULL ,
	email VARCHAR(255) NOT NULL ,
	pwd VARCHAR(255) NOT NULL,
	login_count INT NOT NULL,
	login_timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
mysqli_query($conn, $users_sec);
mysqli_query($conn, $news);

// Add admin:admin user
$username = "admin";
$pwd = "admin";
$email = "admin";
$sql = "INSERT INTO users (username, email, pwd) VALUES ('".$username."', '".$email."', '".$pwd."');";
mysqli_query($conn, $sql);
$sql = "INSERT INTO users_sec (username, email, pwd, login_count) VALUES ('".$username."', '".$email."', '".password_hash($pwd, PASSWORD_DEFAULT)."', 0);";
mysqli_query($conn, $sql);

// Fill table news with dummy content
$number_news = 5;
for ($i = 0; $i < $number_news; $i++) {
	require 'fakename-generator.php';

	$title = file_get_contents('https://loripsum.net/api/1/short/headers', FALSE, NULL, 4, mt_rand(15, 30));
	$img = 'https://picsum.photos/500/300?random='.$i;
	$body = file_get_contents('https://loripsum.net/api/1/short/headers', FALSE, NULL, 4, mt_rand(100, 250));
	$author = $random_fullname;
	$sql = "INSERT INTO news (title, img, body, author) VALUES ('".$title."', '".$img."', '".$body."', '".$author."');";
	mysqli_query($conn, $sql);
}