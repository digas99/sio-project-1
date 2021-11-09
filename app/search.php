<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pesquisar | Área de Administração</title>

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
            session_start();
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
                        <h1 class="h3 mb-0 text-gray-800">Pesquisar</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Resultados da pesquisa</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php
                                        if(isset($_GET["s"])){
                                            $search = $_GET["s"];
                                            
                                            require '../php/db-handler.php';

                                            $sql = "SELECT *
                                                    FROM news
                                                    WHERE title LIKE '%".$search."%'
                                                    OR body LIKE '%".$search."%'
                                                    OR author LIKE '%".$search."%'";
                                            $query = mysqli_query($conn, $sql);
                                            if(empty($query) || mysqli_num_rows($query) == 0){
                                                echo "<p>Nenhum resultado encontrado para \"".$search."\".</p>";
                                            }else{
                                                echo "<p>Foram encontrados ".mysqli_num_rows($query)." resultados para \"".$search."\".</p>";
                                                echo "<div class=\"table-responsive\">
                                                        <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                                            <thead>
                                                                <tr>
                                                                    <th>Título</th>
                                                                    <th>Imagem de Capa</th>
                                                                    <th>Corpo</th>
                                                                    <th>Autor</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                ";

                                                while($row = mysqli_fetch_array($query)){
                                                    echo "      <tr>
                                                                    <td>" . $row['title'] . "</td>
                                                                    <td>
                                                                        <img src=". $row['img'] . " alt=\"\" width=\"150\" class=\"img-fluid\">
                                                                    </td>
                                                                    <td>" . $row['body'] . "</td>
                                                                    <td>" . $row['author'] . "</td>
                                                                </tr>
                                                    ";
                                                }

                                                echo "      </tbody>
                                                        </table>
                                                    </div>
                                                ";
                                            }
                                        }else{
                                            echo "<p>Por favor, introduzida uma palavra-chave para procurar por algo.</p>";
                                        }
                                    ?>
                                </div>
                            </div>
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