<?php
    require 'php/check-session.php';

    // Check if there was a news publish
	if (isset($_POST['publish-submit'])) {
        // Require database handler page
        require 'php/db-handler.php';

        // Fetch information from the publish form
		$title = $_POST['title'];
		$body = $_POST['body'];
		$author = $_POST['author'];

        $fileName = $_FILES['image']['name'];
        $fileTmpName = $_FILES['image']['tmp_name'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $fileNameNew = uniqid('', true).".".$fileActualExt;
        
        $fileDest = 'img/'.$fileNameNew;

        // Upload image to the new location
        if(!move_uploaded_file($fileTmpName, $fileDest)){
            echo "ERROR: There was an error uploading the image.";
        }

        $img = $fileDest;

        $sql = "INSERT INTO news (title, img, body, author) VALUES ('".$title."', '".$img."', '".$body."', '".$author."');";
        if(!mysqli_query($conn, $sql))
            echo "ERROR: Could not execute $sql.<br> " . mysqli_error($conn);
        else
            header("Location: index.php");
            exit();
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

    <title>Publicar notícias | Área de Administração</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Publicar Notícias</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Nova notícia</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                <form method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="title">Título:</label>
                                            <input type="text" name="title" class="form-control" placeholder="Escrever o título da notícia" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="body">Corpo:</label>
                                            <textarea name="body" rows="5" cols="40" class="form-control" placeholder="Escrever o corpo da notícia" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="author">Autor:</label>
                                            <input type="text" name="author" class="form-control" placeholder="Escrever o autor da notícia" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Imagem de capa:</label>
                                            <input type="file" accept=".jpg,.jpeg,.png" name="image" class="form-control" required>
                                            <small class="form-text text-muted">Apenas é permitido enviar um único ficheiro com extensão <code>.jpg</code> ou <code>.png</code>.</small>
                                        </div>
                                        <button type="submit" name="publish-submit" value="post" class="btn btn-primary">Publicar</button>
                                    </form>
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
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>