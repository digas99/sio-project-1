<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
  	<link rel="stylesheet" href="styles/styles.css">
</head>

<body style="text-align:center">
	<div class="centered-container">
		<h1>Login</h1>
		<div>
			<form action="login.php" method="post">
				<input type="text" name="username" placeholder="Username...">
				<input type="password" name="pwd" placeholder="Password...">
				<button type="submit" name="login-submit">Login</button>
			</form>
			<div style="margin-top:10px">Don't have an account? <a href="signup.php">Signup</a><div>
		</div>
	</div>

  	<!-- <script src="js/scripts.js"></script> -->
</body>
</html>