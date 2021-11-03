<?php
    require 'php/check-session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Recuperar palavra-passe | Área de Administração</title>

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
                    <h1 class="h4 text-gray-900 mb-2">Recuperar palavra-passe</h1>
                    <p class="mb-4">Digite o seu endereço de e-mail abaixo e <br>enviaremos um link para redefinir a sua palavra-passe</p>
                </div>
                <form class="user">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="email" placeholder="Email" required>
                    </div>
                    <button type="submit" name="password-recover-submit" class="btn btn-primary btn-user btn-block">
                        Redefinir palavra-passe
                    </button>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="signup.php">Criar uma conta</a>
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