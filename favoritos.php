<?php
session_start();
include("include/conexion.php");
include("include/conexion_sispa.php");
include("include/busquedas.php");
include("include/busquedas_sispa.php");
include("include/funciones.php");
include("include/verificar_sesion.php");

if (!verificar_sesion($conexion) == 1) {
    echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('index.php');
              </script>";
} else {

    $buscar_sesion= buscar_sesion($conexion, $_SESSION['id_sesion_biblioteca']);
    $r_buscar_sesion = mysqli_fetch_array($buscar_sesion);

    if ($r_buscar_sesion['tipo_acceso'] == 'docente') {
        $b_usuario = buscarDocenteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
        $tipo_usuario = "docente";
    }elseif ($r_buscar_sesion['tipo_acceso'] == 'estudiante') {
        $b_usuario = buscarEstudianteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
        $tipo_usuario = "estudiante";
    }else {
        echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('index.php');
              </script>";
    }
    $r_b_usuario = mysqli_fetch_array($b_usuario);

?>

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
                                    <img class="card-img-top img-fluid" src="https://drive.google.com/uc?export=view&id=1tpugzZzQI17IV7KPnZ0C6ZPCCMCQoUmY" alt="Card image cap">
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


    <?php include "include/pie_scripts.php"; ?>

</body>

</html>
<?php }