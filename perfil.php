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

    $buscar_sesion = buscar_sesion($conexion, $_SESSION['id_sesion_biblioteca']);
    $r_buscar_sesion = mysqli_fetch_array($buscar_sesion);

    if ($r_buscar_sesion['tipo_acceso'] == 'docente') {
        $b_usuario = buscarDocenteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
        $tipo_usuario = "docente";
        $r_b_usuario = mysqli_fetch_array($b_usuario);

        $b_programa = buscarCarrerasById($conexion_sispa, $r_b_usuario['id_programa_estudio']);
        $r_b_programa = mysqli_fetch_array($b_programa);
    } elseif ($r_buscar_sesion['tipo_acceso'] == 'estudiante') {
        $b_usuario = buscarEstudianteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
        $tipo_usuario = "estudiante";
        $r_b_usuario = mysqli_fetch_array($b_usuario);

        $b_programa = buscarCarrerasById($conexion_sispa, $r_b_usuario['id_programa_estudios']);
        $r_b_programa = mysqli_fetch_array($b_programa);
    } else {
        echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('index.php');
              </script>";
    }

?>


    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <title>Detalle - IESTP HUANTA</title>
        <?php include "include/header.php"; ?>
        <!-- Script obtenido desde CDN jquery -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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
                                    <h4 class="mb-0 font-size-18">Mi Perfil</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <h4><?php echo $r_b_libro['titulo']; ?></h4>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p><b>DNI</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_usuario['dni']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Apellidos y Nombres</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_usuario['apellidos_nombres']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Correo Electrónico</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_usuario['correo']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Telefono</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_usuario['telefono']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Dirección</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_usuario['direccion']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Programa de Estudio</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_programa['nombre']; ?></p>
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


        <?php include "include/pie_scripts.php"; ?>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#btn_agregar').click(function() {
                    agregar_favorito();
                });
            })
        </script>
        <script type="text/javascript">
            function agregar_favorito() {
                $.ajax({
                    type: "POST",
                    url: "add_favorito.php",
                    data: "libro=" + $('#librodd').val(),
                    success: function(r) {
                        $('#mostrar_noti').html(r);
                    }
                });
            }
        </script>

    </body>

    </html>

<?php }
