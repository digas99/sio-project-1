<?php
	// check if there was a signup submition
	if (isset($_POST['signup-submit'])) {
		// require database handler page
		// require 'db-handler.php';

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

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Criar conta | Área de Administração</title>

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
        <!-- Sidebar -->
        <?php
            require 'sidebar.php';
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <div class="p-5" style="max-width: 710px; margin: auto;">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Criar uma conta</h1>
                    </div>
                    <?php
                        // put error messages
                        if (isset($_GET['error'])) {
                            switch($_GET['error']) {
                                case "emptyfields":
                                    echo '<p style="color: red; text-align: center;">Fill in all fields!</p>';
                                    break;
                                case "missmatchpwd":
                                    echo '<p style="color: red; text-align: center;">Passwords don\'t match!</p>';
                                    break;
                            }
                        }
                    ?>
                    <form action="signup.php" method="post" class="user">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user"
                                name="username" placeholder="Nome de utilizador" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user"
                                name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user"
                                    name="password" placeholder="Palavra-passe" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user"
                                    name="repeat-password" placeholder="Repetir palavra-passe" required>
                            </div>
                        </div>
                        <button type="submit" name="signup-submit" class="btn btn-primary btn-user btn-block">
                            Criar conta
                        </button>
                        <?php
                            // fill in username from url query
                            if (isset($_GET['username'])) echo "<script>Array.from(document.getElementsByTagName('INPUT')).filter(tag => tag.name === 'username')[0].value = '".$_GET['username']."'; </script>";
                        ?>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="forgot-password.php">Recuperar palavra-passe</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="login.php">Iniciar sessão</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>