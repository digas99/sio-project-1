<?php
    require '../php/check-session.php';

    // check if there was a change password submition
	if (isset($_POST['change-submit'])) {
		// require database handler page
		require '../php/db-handler.php';

		// fetch information from the signup form
        $oldPwd = $_POST['old-password'];
		$pwd = $_POST['new-password'];
		$pwdRepeat = $_POST['repeat-new-password'];
        
        // check for old password
        $sql = "SELECT * FROM users_sec WHERE username=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: change-password.php?submit=error");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, 's', $_SESSION['userUsername']);
            mysqli_stmt_execute($stmt);
            $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
            if (!password_verify($oldPwd, $row['pwd'])) {
                header("Location: change-password.php?submit=oldpwderror");
                exit();
            }
            else {
                // missmatch passwords handler
                if ($pwd !== $pwdRepeat) {
                    header("Location: change-password.php?submit=invalid");
                    exit();

                }else if($pwd === $oldPwd){
                    header("Location: change-password.php?submit=sameoldpwd");
                    exit();
                }else if(strlen($pwd) < 8 || !preg_match('/[A-Z]/', $pwd) || !preg_match('/[\'^£$%&*()}!{@#~?><>,|=_+¬-]/', $pwd)){
                    header("Location: change-password.php?submit=pwdnotvalid");
                    exit();
                } else {
                    $sql = "UPDATE users_sec SET pwd=? WHERE username='".$_SESSION["userUsername"]."'";
                    $stmt = mysqli_stmt_init($conn);

                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, 's', password_hash($pwd, PASSWORD_DEFAULT));
                        if (!mysqli_stmt_execute($stmt)) {
                            header("Location: change-password.php?submit=error");
                            exit();
                        }
                        else {
                            header("Location: change-password.php?submit=success");
                        }
                    }
                }
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

    <title>Alterar palavra-passe | Área de Administração</title>

    <!-- Custom fonts for this template-->
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

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

                <!-- Navbar -->
                <?php
                    require 'navbar.php';
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Alterar palavra-passe</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">

                            <?php
                                // put error messages
                                if (isset($_GET['submit'])) {
                                    switch ($_GET['submit']) {
                                        case 'success':
                                            echo "
                                                <div class=\"alert alert-success alert-dismissible fade show\">
                                                    <i class=\"fas fa-check-circle\"></i> <strong>SUCESSO:</strong> A palavra-passe foi alterada com sucesso!
                                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                        <span aria-hidden=\"true\">×</span>
                                                    </button>
                                                </div>
                                            ";
                                            break;

                                        case 'error':
                                            echo "
                                                <div class=\"alert alert-danger alert-dismissible fade show\">
                                                    <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> Ocorreu um problema ao tentar alterar a palavra-passe!
                                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                        <span aria-hidden=\"true\">×</span>
                                                    </button>
                                                </div>
                                            ";
                                            break;

                                        case 'invalid':
                                            echo "
                                                <div class=\"alert alert-danger alert-dismissible fade show\">
                                                    <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> As palavras-passe não são iguais!
                                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                        <span aria-hidden=\"true\">×</span>
                                                    </button>
                                                </div>
                                            ";
                                            break;
                                    
                                        case 'oldpwderror':
                                            echo "
                                                <div class=\"alert alert-danger alert-dismissible fade show\">
                                                    <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> A palavra-passe antiga não está correta!
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
                                        case "sameoldpwd":
                                            echo "
                                                <div class=\"alert alert-danger alert-dismissible fade show\">
                                                    <i class=\"fas fa-times-circle\"></i> <strong>ERRO:</strong> A nova palavra-passe é a mesma que a palavra-passe antiga!
                                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                                        <span aria-hidden=\"true\">×</span>
                                                    </button>
                                                </div>
                                            ";
                                            break;
                                    }
                                }
                            ?>

                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Alteração da palavra-passe</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group" style="position:relative;">
                                            <label for="old-password">Palavra-passe antiga:</label>
                                            <input type="password" name="old-password" class="form-control" placeholder="Escrever a palavra-passe antiga" required>
                                            <i class="fas fa-eye show-pwd"></i>
                                        </div>
                                        <div class="form-group" style="position:relative;">
                                            <label for="new-password">Nova palavra-passe:</label>
                                            <input type="password" name="new-password" class="form-control" placeholder="Escrever a nova palavra-passe" required>
                                            <i class="fas fa-eye show-pwd"></i>
                                        </div>
                                        <div class="form-group" style="position:relative;">
                                            <label for="repeat-new-password">Confirmar nova palavra-passe:</label>
                                            <input type="password" name="repeat-new-password" class="form-control" placeholder="Repetir a nova palavra-passe" required>
                                            <i class="fas fa-eye show-pwd"></i>
                                        </div>
                                        <button type="submit" name="change-submit" value="post" class="btn btn-primary">Alterar</button>
                                    </form>
                                </div>
                            </div>

                            <style>
                                .show-pwd {
                                    position: absolute;
                                    right: 18px;
                                    top: 32px;
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
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Custom scripts for all pages-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>

</body>

</html>