<?php
    session_start(); 

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
            
                        header("Location: login.php?submit=login");
                        exit();
                    }
                    else {
                        // Password is incorrect
                        header("Location: login.php?submit=pwdinvalid&username=".$username);
                        exit();
                    }
                }
            }
            else {
                // Username not found
                header("Location: login.php?submit=usernameinvalid");
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
                        if (isset($_GET['submit'])) {
                            switch($_GET['submit']) {
                                case "usernameinvalid":
                                    echo "
                                        <div class=\"alert alert-danger alert-dismissible fade show\">
                                            <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> O nome de utilizador introduzido não existe!
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                                case "pwdinvalid":
                                    echo "
                                        <div class=\"alert alert-danger alert-dismissible fade show\">
                                            <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> A palavra-passe para a conta introduzida está incorreta!
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
                    <form action="login.php" method="post" class="user">
                        <div class="form-group">
                            <input class="form-control form-control-user" name="username" placeholder="Nome de utilizador" required>
                        </div>
                        <div class="form-group" style="position:relative;">
                            <input class="form-control form-control-user" name="password" placeholder="Palavra-passe" required>
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