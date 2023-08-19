<?php 
include "include/conexion.php";


/*for ($i=0; $i < 100; $i++) { 
    $bss = "INSERT INTO libros (titulo, descripcion, paginas) VALUES ('titulo','descripcion','100')";
    $ejec = mysqli_query($conexion, $bss);
    if ($ejec) {
        //echo "registrado";
    }else {
        //echo "error";
    }
}*/


?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Detalle - IESTP HUANTA</title>
    <?php include "include/header.php"; ?>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        <div class="main-content">
            <?php include "include/menu.php"; ?>
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">Información de Libro</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <img class="card-img-top img-fluid" src="images/libro.jpg" alt="Card image cap">
                                            <center>
                                                <button type="button" class="btn btn-danger"><i class="fas fa-heart"></i></button>
                                                <a href="lectura.php"  class="btn btn-info">Leer Libro</a>
                                            </center>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <h4>TITULO DEL LIBRO</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p><b>Nro de Páginas</b></p>
                                                    <p><b>Autor</b></p>
                                                    <p><b>Editorial</b></p>
                                                    <p><b>Edición</b></p>
                                                    <p><b>Tomo</b></p>
                                                    <p><b>Categoría</b></p>
                                                    <p><b>Temas Relacionados</b></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>: 189</p>
                                                    <p>: Anibal Yucra Curo</p>
                                                    <p>: I.E.S.T.P. HUANTA</p>
                                                    <p>: 2023</p>
                                                    <p>: I</p>
                                                    <p>: Investigación</p>
                                                    <p>: Desarrollo, Programación, Diseño</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include "include/footer.php"; ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- jQuery  -->
    <script src="pp/assets/js/jquery.min.js"></script>
    <script src="pp/assets/js/bootstrap.bundle.min.js"></script>
    <script src="pp/assets/js/waves.js"></script>
    <script src="pp/assets/js/simplebar.min.js"></script>

    <!-- App js -->
    <script src="pp/assets/js/theme.js"></script>

</body>

</html>