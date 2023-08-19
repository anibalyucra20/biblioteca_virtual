<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Mis Favoritos - IESTP HUANTA</title>
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
                                <h4 class="mb-0 font-size-18">Mis Libros Favoritos <i class="fas fa-heart"></i> </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php for ($i = 0; $i < 12; $i++) { ?>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <img class="card-img-top img-fluid" src="images/libro.jpg" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">Titulo del Libro</h5>
                                        <p class="card-text">Carrera al que pertenece</p>
                                        <p class="card-text">Autor: Autor del libro</p>
                                        <center><a href="detalle.php" class="btn btn-info">Ver</a></center>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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