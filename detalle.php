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
                                                <div class="col-md-4"><p><b>Nro de Páginas</b></p></div>
                                                <div class="col-md-6"><p>: 189</p></div>
                                                <div class="col-md-4"><p><b>Autor</b></p></div>
                                                <div class="col-md-6"><p>: Anibal Yucra Curo</p></div>
                                                <div class="col-md-4"><p><b>Editorial</b></p></div>
                                                <div class="col-md-6"><p>: I.E.S.T.P. HUANTA</p></div>
                                                <div class="col-md-4"><p><b>Edición</b></p></div>
                                                <div class="col-md-6"><p>: 2023</p></div>
                                                <div class="col-md-4"><p><b>Tomo</b></p></div>
                                                <div class="col-md-6"><p>: I</p></div>
                                                <div class="col-md-4"><p><b>Categoría</b></p></div>
                                                <div class="col-md-6"><p>: Investigación</p></div>
                                                <div class="col-md-4"><p><b>Temas Relacionados</b></p></div>
                                                <div class="col-md-6"><p>: Desarrollo, Programación, Diseño</p></div>
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


    <?php include "include/pie_scripts.php"; ?>

</body>

</html>

<?php }