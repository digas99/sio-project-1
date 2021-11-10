<?php
    session_start();

    // set timezone to Lisbon (Portugal)
    date_default_timezone_set("Europe/Lisbon");

    // require database handler page
    require '../php/db-handler.php';

    // check if tables need to be created
    if (!mysqli_query($conn, "DESCRIBE users") || !mysqli_query($conn, "DESCRIBE users_sec") || !mysqli_query($conn, "DESCRIBE news"))
        require '../php/setup-tables.php';

    // destroy session if logout
    if (isset($_GET['submit']) && $_GET['submit'] == "logout")
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

        $attempts_limit = 3;    // 3 attempts
        $lockout_time = 600;    // 600 seconds = 10 minutes

        // check if username exists
        $sql = "SELECT * FROM users_sec WHERE username=?;";
        $stmt = mysqli_stmt_init($conn);
        // check if the query makes sense
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: login.php?submit=error");
            exit();
        }
        else {
            // use binding to prevent executing queries from the user
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            // fetch rows
            if ($row = mysqli_fetch_assoc($result)) {

                $timestamp_failed_login = $row['login_timestamp'];
                $attempts = $row['login_count'];

                if( ($attempts >= $attempts_limit) && (time() - strtotime($timestamp_failed_login) < $lockout_time) ){
                    // User is lockout, too many attempts made
                    header("Location: login.php?submit=lockout");
                    exit();
                } else {
                    // User is not lockout, login is allowed
                    $pwd_check = password_verify($pwd, $row['pwd']);
                    if ($pwd_check == true){
                        // Correct password
                        session_start();
            
                        $_SESSION['userId'] = $row['id'];
                        $_SESSION['userUsername'] = $row['username'];

                        $attempts = 0;
                        $sql = "UPDATE users_sec SET login_count = ".$attempts." WHERE username='".$row['username']."';";
                        if(!mysqli_query($conn, $sql)){
                            header("Location: login.php?submit=error");
                            exit();
                        }

                        header("Location: login.php?submit=login");
                        exit();
                    }
                    else {
                        // Password is incorrect
                        $attempts++;

                        $sql = "UPDATE users_sec SET login_count = ".$attempts.", login_timestamp = NOW() WHERE username='".$row['username']."';";
                        if(!mysqli_query($conn, $sql)){
                            header("Location: login.php?submit=error");
                            exit();
                        }

                        header("Location: login.php?submit=invalid");
                        exit();
                    }
                }
            }
            else {
                // Username not found
                header("Location: login.php?submit=invalid");
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
            require 'sidebar-noaccess.php';
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
                        if (isset($_GET['submit'])) {
                            switch($_GET['submit']) {
                                case "invalid":
                                    echo "
                                        <div class=\"alert alert-danger alert-dismissible fade show\">
                                            <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> As credenciais introduzidas são inválidas! Por favor tente novamente.
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                                case "lockout":
                                    echo "
                                        <div class=\"alert alert-danger alert-dismissible fade show\">
                                            <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> O limite de tentativas foi atingido! Por favor aguarde 10 minutos até tentar novamente.
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                                case "error":
                                    echo "
                                        <div class=\"alert alert-danger alert-dismissible fade show\">
                                            <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> Ocorreu um problema ao tentar iniciar sessão!
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                                case "logout":
                                    echo "
                                        <div class=\"alert alert-success alert-dismissible fade show\">
                                            <i class=\"fas fa-check-circle\"></i> <strong>SUCESSO:</strong> Sessão terminada com sucesso!
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                                case "login":
                                    echo "
                                        <div class=\"alert alert-success alert-dismissible fade show\">
                                            <i class=\"fas fa-check-circle\"></i> <strong>SUCESSO:</strong> Sessão iniciada com sucesso!
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                            }
                        }
                    ?>
                    <form action="login" method="post" class="user">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="username" placeholder="Nome de utilizador" required>
                        </div>
                        <div class="form-group" style="position:relative;">
                            <input type="password" class="form-control form-control-user" name="password" placeholder="Palavra-passe" required>
                            <i class="fas fa-eye show-pwd"></i>
                            <style>
                                .show-pwd {
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
                                // add event listener to all show pwd
                                Array.from(document.getElementsByClassName("show-pwd"))
                                    .forEach(eye => {
                                        const input = Array.from(eye.parentElement.children).filter(child => child.tagName=='INPUT')[0];
                                        eye.addEventListener("click", () => {
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
                                    });
                            </script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>

</body>

</html>