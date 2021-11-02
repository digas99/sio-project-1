<?php
	// check if there was a login submition
	if (isset($_POST['login-submit'])) {
		// require database handler page
		require 'db-handler.php';

		// fetch information from the login form
		$username = $_POST['username'];
		$pwd = $_POST['pwd'];

		// empty fields handler
		if (empty($username) || empty($pwd)) {
			header("Location: login.php?error=emptyfields&username=".$username);
			exit();
		}

		// TODO: check if user exists in the database, and if so, if the password is correct

		// TODO: session_start() and header location dashboard.php
	}
?>

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
		<h1><a href="login.php">Login</a></h1>
		<?php
			// put error messages
			if (isset($_GET['error'])) {
				switch($_GET['error']) {
					case "emptyfields":
						echo '<p class="error-message">Fill in all fields!</p>';
						break;
				}
			}
		?>
		<div>
			<form action="login.php" method="post">
				<input type="text" name="username" placeholder="Username...">
				<input type="password" name="pwd" placeholder="Password...">
				<button type="submit" name="login-submit">Login</button>
				<?php
					// fill in username from url query
					if (isset($_GET['username'])) echo "<script>Array.from(document.getElementsByTagName('INPUT')).filter(tag => tag.name === 'username')[0].value = '".$_GET['username']."'; </script>";
				?>
			</form>
			<div style="margin-top:10px">Don't have an account? <a href="signup.php">Signup</a></div>
		</div>
	</div>

  	<!-- <script src="js/scripts.js"></script> -->
</body>
</html>