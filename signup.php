<?php
	// check if there was a signup submition
	if (isset($_POST['signup-submit'])) {
		// require database handler page
		require 'db-handler.php';

		// fetch information from the signup form
		$username = $_POST['username'];
		$pwd = $_POST['pwd'];
		$pwdRepeat = $_POST['pwd-rpt'];

		// empty fields handler
		if (empty($username) || empty($pwd) || empty($pwdRepeat)) {
			header("Location: signup.php?error=emptyfields&username=".$username);
			exit();
		}
		
		// missmatch passwords handler
		if ($pwd !== $pwdRepeat) {
			header("Location: signup.php?error=missmatchpwd&username=".$username);
			exit();
		}

		// TODO: check for username taken in the database

		// TODO: add user to the database and header location dashboard.php
	}
?>

<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Signup</title>
  	<link rel="stylesheet" href="styles/styles.css">
</head>

<body style="text-align:center">
	<div class="centered-container">
		<h1><a href="signup.php">Signup</a></h1>
		<?php
			// put error messages
			if (isset($_GET['error'])) {
				switch($_GET['error']) {
					case "emptyfields":
						echo '<p class="error-message">Fill in all fields!</p>';
						break;
					case "missmatchpwd":
						echo '<p class="error-message">Passwords don\'t match!</p>';
						break;
				}
			}
		?>
		<div>
			<form action="signup.php" method="post">
				<input type="text" name="username" placeholder="Username...">
				<input type="password" name="pwd" placeholder="Password...">
				<input type="password" name="pwd-rpt" placeholder="Repeat Password...">
				<button type="submit" name="signup-submit">Signup</button>
				<?php
					// fill in username from url query
					if (isset($_GET['username'])) echo "<script>Array.from(document.getElementsByTagName('INPUT')).filter(tag => tag.name === 'username')[0].value = '".$_GET['username']."'; </script>";
				?>
			</form>
			<div style="margin-top:10px">Already have an account? <a href="login.php">Login</a></div>
		</div>
	</div>

  	<!-- <script src="js/scripts.js"></script> -->
</body>
</html>