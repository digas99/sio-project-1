<?php
	// check if there was a login submition
	if (isset($_POST['login-submit'])) {
		// require database handler page
		// require 'db-handler.php';

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

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- SIDEBAR -->
        <?php
            require 'sidebar.php';
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <div class="p-5" style="max-width: 710px; margin: auto;">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                    </div>
                    <?php
                        // put error messages
                        if (isset($_GET['error'])) {
                            switch($_GET['error']) {
                                case "emptyfields":
                                    echo '<p style="color: red; text-align: center;">Fill in all fields!</p>';
                                    break;
                            }
                        }
                    ?>
                    <form action="login.php" method="post" class="user">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" 
                                name="username" placeholder="Username...">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user"
                                name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Remember
                                    Me</label>
                            </div>
                        </div>
                        <button type="submit" name="login-submit" class="btn btn-primary btn-user btn-block">
                            Login
                        </button>
                        <?php
                            // fill in username from url query
                            if (isset($_GET['username'])) echo "<script>Array.from(document.getElementsByTagName('INPUT')).filter(tag => tag.name === 'username')[0].value = '".$_GET['username']."'; </script>";
                        ?>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="forgot-password.php">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="signup.php">Create an Account!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>