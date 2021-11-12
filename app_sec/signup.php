<?php
    session_start();

    // require database handler page
    require '../php/db-handler.php';

    // check if tables need to be created
    if (!mysqli_query($conn, "DESCRIBE users") || !mysqli_query($conn, "DESCRIBE users_sec") || !mysqli_query($conn, "DESCRIBE news"))
        require '../php/setup-tables.php';

    // if already in session then go to dashboard
    if(isset($_SESSION["userId"])){
        header("Location: index.php");
        exit();
    }   

	// check if there was a signup submition
	if (isset($_POST['signup-submit'])) {
		// fetch information from the signup form
		$username = trim($_POST['username']);
		$pwd = $_POST['password'];
		$pwdRepeat = $_POST['repeat-password'];
        $email = $_POST['email'];
		// missmatch passwords handler
		if ($pwd !== $pwdRepeat) {
			header("Location: signup.php?submit=missmatchpwd&username=".$username."&email=".$email);
			exit();
		}else if(strlen($pwd) < 8 || !preg_match('/[A-Z]/', $pwd) || !preg_match('/[\'^£$%&*()}!{@#~?><>,|=_+¬-]/', $pwd)){
			header("Location: signup.php?submit=pwdnotvalid&username=".$username."&email=".$email);
		    exit();
        }
        else {
            // check if username exists
            $sql = "SELECT * FROM users WHERE username=?;";
            $stmt = mysqli_stmt_init($conn);
            // check if the query makes sense
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: signup.php?submit=error");
                exit();
            }
            else {
                // use binding to prevent executing queries from the user
                mysqli_stmt_bind_param($stmt, 's', $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                // check if any rows where fetched
                if (mysqli_num_rows($result) == 0) {
                    // check if mail exists
                    $sql = "SELECT * FROM users WHERE email=?;";
                    $stmt = mysqli_stmt_init($conn);
                    // check if the query makes sense
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: signup.php?submit=error");
                        exit();
                    }
                    else {
                        // use binding to prevent executing queries from the user
                        mysqli_stmt_bind_param($stmt, 's', $email);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        // check if any rows where fetched
                        if (mysqli_num_rows($result) == 0) {
                            // if not taken, then add it to database
                            $sql = "INSERT INTO users_sec (username, email, pwd, login_count) VALUES (?, ?, ?, 0);";
                            $stmt = mysqli_stmt_init($conn);
                            // check if the query makes sense
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header("Location: signup.php?submit=error");
                                exit();
                            }
                            else {
                                // use binding to prevent executing queries from the user
                                mysqli_stmt_bind_param($stmt, 'sss', $username, $email, password_hash($pwd, PASSWORD_DEFAULT));
                                mysqli_stmt_execute($stmt);

                                header("Location: login.php?username=".$username);
                                exit();
                            }
                        }
                        else {
                            header("Location: signup.php?submit=emailtaken&username=".$username);
                            exit();
                        }
                    }
                }
                else {
                    header("Location: signup.php?submit=usernametaken&email=".$email);
                    exit();
                }
            }
        }

        // mysqli_stmt_close($stmt);
        // mysqli_close($conn);
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Criar conta | Área de Administração</title>

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
                        <h1 class="h4 text-gray-900 mb-4">Criar uma conta</h1>
                    </div>
                    <?php
                        if (isset($_GET['submit'])) {
                            switch($_GET['submit']) {
                                case "error":
                                    echo "
                                        <div class=\"alert alert-danger alert-dismissible fade show\">
                                            <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> Ocorreu um problema ao tentar criar conta!
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                                case "emailtaken":
                                    echo "
                                        <div class=\"alert alert-danger alert-dismissible fade show\">
                                            <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> O email introduzido já está associado a outra conta!
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                                case "usernametaken":
                                    echo "
                                        <div class=\"alert alert-danger alert-dismissible fade show\">
                                            <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> O nome de utilizador escolhido já está em uso!
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                                case "missmatchpwd":
                                    echo "
                                        <div class=\"alert alert-danger alert-dismissible fade show\">
                                            <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> As palavras-passe introduzidas não são iguais!
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                                case "pwdnotvalid":
                                    echo "
                                        <div class=\"alert alert-danger alert-dismissible fade show\">
                                            <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> A palavra-passe introduzida não cumpre os requisitos mínimos (pelo menos 8 caracteres, uma letra maiúscula e um símbolo)!
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                    ";
                                    break;
                            }
                        }
                    ?>
                    <form action="signup" method="post" class="user">
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
                            if (isset($_GET['email'])) echo "<script>Array.from(document.getElementsByTagName('INPUT')).filter(tag => tag.name === 'email')[0].value = '".$_GET['email']."'; </script>";
                        ?>
                    </form>
                    <hr>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>

</body>

</html>