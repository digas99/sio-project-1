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
		<h1>Signup</h1>
		<div>
			<form action="signup.php" method="post">
				<input type="text" name="username" placeholder="Username...">
				<input type="password" name="pwd" placeholder="Password...">
				<input type="password" name="pwd-rpt" placeholder="Repeat Password...">
				<button type="submit" name="login-submit">Signup</button>
			</form>
			<div style="margin-top:10px">Already have an account? <a href="login.php">Login</a><div>
		</div>
	</div>

  	<!-- <script src="js/scripts.js"></script> -->
</body>
</html>