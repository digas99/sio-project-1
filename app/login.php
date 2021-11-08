<?php
    session_start(); 

    // require database handler page
    require 'php/db-handler.php';

    // check if tables need to be created
    if (!mysqli_query($conn, "DESCRIBE users") || !mysqli_query($conn, "DESCRIBE news"))
        require 'php/setup-tables.php';

    // destroy session if logout
    if (isset($_GET['success']) && $_GET['success'] == "logout")
        session_destroy();
    // if already in session then go to dashboard
    else if(isset($_SESSION["userId"])){
        header("Location: index.php");
        exit();
    }   

	// check if there was a login submition
	if (isset($_POST['login-submit'])) {
		// fetch information from the login form
		$username = trim($_POST['username']);
		$pwd = $_POST['password'];

        // check if username exists
        $sql = "SELECT username FROM users WHERE username='".$username."'";
        $query = mysqli_query($conn, $sql);
        if(!$query) {
            echo "ERROR: Could not execute $sql.<br> " . mysqli_error($conn);
            exit();
        }
        else {
            if (mysqli_num_rows($query) !== 0) {
                $row = mysqli_fetch_assoc($query);
            
                // check if password matches
                $sql = "SELECT username, id, pwd FROM users WHERE username='".$username."' AND pwd='".$pwd."'";
                $query = mysqli_query($conn, $sql);
                if(!$query) {
                    echo "ERROR: Could not execute $sql.<br> " . mysqli_error($conn);
                    exit();
                }
                else {
                    $row = mysqli_fetch_assoc($query);
                    if ($row) {
                        session_start();
        
                        $_SESSION['userId'] = $row['id'];
                        $_SESSION['userUsername'] = $row['username'];
            
                        header("Location: login.php?success=login");    
                    }
                    else {
                        // password doesn't exist
                        header("Location: login.php?error=pwdinvalid&username=".$username);
                        exit();
                    }
                }
            }
            else {
                // username doesn't exist
                header("Location: login.php?error=usernameinvalid");
                exit();
            }
        }    
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

    <title>Iniciar sessão | Área de Administração</title>

    <!-- Custom fonts for this template-->
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

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
                        <h1 class="h4 text-gray-900 mb-4">Bem-vindo de volta!</h1>
                    </div>
                    <?php
                        // put error messages
                        if (isset($_GET['error'])) {
                            switch($_GET['error']) {
                                case "usernameinvalid":
                                    echo '<p style="color: red; text-align: center;">Username doesn\'t exist!</p>';
                                    break;
                                case "pwdinvalid":
                                    echo '<p style="color: red; text-align: center;">Password is incorrect!</p>';
                                    break;
                            }
                        }

                        // put success messages
                        if (isset($_GET['success'])) {
                            switch($_GET['success']) {
                                case "login":
                                    echo '<p style="color: green; text-align: center;">Logged in successfully!</p>';
                                    break;
                                case "logout":
                                    echo '<p style="color: green; text-align: center;">Logged out successfully!</p>';
                                    break;   
                            }
                        }

                    ?>
                    <form action="login.php" method="post" class="user">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="username" placeholder="Nome de utilizador" required>
                        </div>
                        <div class="form-group" style="position:relative;">
                            <input type="text" class="form-control form-control-user" name="password" placeholder="Palavra-passe" required>
                            <i class="fas fa-eye" id="show-pwd"></i>
                            <style>
                                #show-pwd {
                                    position: absolute;
                                    right: 18px;
                                    top: 0;
                                    bottom: 0;
                                    margin: auto;
                                    height: fit-content;
                                    font-size: 20px;
                                    cursor: pointer;
                                }
                            </style>

                            <script>
                                const eye = document.getElementById("show-pwd");
                                eye.addEventListener("click", () => {
                                    const input = eye.parentElement.children[0];
                                    // if eye with no slash then show pwd after click
                                    if (eye.classList.contains("fa-eye")) {
                                        input.type = 'text';
                                        eye.classList.remove("fa-eye");
                                        eye.classList.add("fa-eye-slash");
                                    }
                                    else {
                                        input.type = 'password';
                                        eye.classList.remove("fa-eye-slash");
                                        eye.classList.add("fa-eye");
                                    }
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Manter sessão iniciada</label>
                            </div>
                        </div>
                        <button type="submit" name="login-submit" class="btn btn-primary btn-user btn-block">
                            Iniciar sessão
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
                        <a class="small" href="signup.php">Criar uma conta</a>
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