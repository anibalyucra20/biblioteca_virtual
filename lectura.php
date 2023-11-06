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
    <title>Lectura - IESTP HUANTA</title>
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
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4>TITULO DEL LIBRO</h4>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                        <iframe src="https://drive.google.com/file/d/1jw4Q8xpOvgp11fDmVB2EYqNrjF3JNz5n/preview" width="100%" height="900"></iframe>
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

    <?php include "include/pie_scripts.php"; ?>

</body>

</html>


<?php }