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
    } elseif ($r_buscar_sesion['tipo_acceso'] == 'estudiante') {
        $b_usuario = buscarEstudianteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
        $tipo_usuario = "estudiante";
    } else {
        echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('index.php');
              </script>";
    }
    $r_b_usuario = mysqli_fetch_array($b_usuario);

    $link_libro = $_GET['libro'];
    $b_libro = buscar_libroByLinkPortada($conexion, $link_libro);
    $r_b_libro = mysqli_fetch_array($b_libro);

?>


    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <title>Lectura - IESTP HUANTA</title>
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
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <input type="hidden" id="librodd" value="<?php echo $link_libro; ?>">
                                                        <?php
                                                        $b_favorito = buscar_favoritosByidLibroUsuTipo($conexion, $r_b_libro['id'], $r_buscar_sesion['id_usuario'], $tipo_usuario);
                                                        $cont = mysqli_num_rows($b_favorito);
                                                        if ($cont > 0) {
                                                            $color = "danger";
                                                            $texto = "Quitar de Favoritos";
                                                        } else {
                                                            $color = "dark";
                                                            $texto = "Agregar a Favoritos";
                                                        }
                                                        ?>
                                                        <div id="mostrar_noti">
                                                            <button type="button" class="btn btn-outline-<?php echo $color; ?> waves-effect waves-light" id="btn_agregar"> <?php echo $texto; ?> <i class="fas fa-heart"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <center>
                                                            <h4><?php echo $r_b_libro['titulo'] ?></h4>
                                                        </center>
                                                    </div>
                                                    <div class="col-md-4" id="mostrar_noti">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3" style="position: relative; background: #1e1e1f">
                                            <iframe src="https://drive.google.com/file/d/<?php echo $r_b_libro['link_libro']; ?>/preview" width="100%" height="900"></iframe>
                                                <div style="width:200px; height:50px; position:absolute; background: transparent; right:12px; top: 12px;"><img src="https://biblioteca.iestphuanta.edu.pe/images/logo.png" alt="" width="100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php
                    // registrar lectura


                    $id_libro = $r_b_libro['id'];
                    $id_sesion = $_SESSION['id_sesion_biblioteca'];
                    $id_usuario = $r_buscar_sesion['id_usuario'];
                    $fecha_hora = date("Y-m-d H:i:s");
                    $cont = 0;

                    $b_lecturas = buscar_lecturasByidLibroUsuTipo($conexion, $id_libro, $id_usuario, $tipo_usuario);
                    while ($r_b_lecturas = mysqli_fetch_array($b_lecturas)) {
                        if (date("Y-m-d", strtotime($r_b_lecturas['fecha_hora'])) == date("Y-m-d")) {
                            $cont++;
                        }
                    }
                    if ($cont < 1) {
                        $consulta = "INSERT INTO lecturas (id_sesion, id_usuario, tipo_usuario, id_libro, fecha_hora) VALUES ('$id_sesion', '$id_usuario', '$tipo_usuario', '$id_libro', '$fecha_hora')";
                        $ejecutar = mysqli_query($conexion, $consulta);
                    }

                    ?>



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
