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

    $b_programa = buscarCarrerasById($conexion_sispa, $r_b_libro['id_programa_estudio']);
    $r_b_programa = mysqli_fetch_array($b_programa);

    $b_semestre = buscarSemestreById($conexion_sispa, $r_b_libro['id_semestre']);
    $r_b_semestre = mysqli_fetch_array($b_semestre);

    $b_ud = buscarUdById($conexion_sispa, $r_b_libro['id_unidad_didactica']);
    $r_b_ud = mysqli_fetch_array($b_ud);

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
                                                <img class="card-img-top img-fluid" src="https://drive.google.com/uc?export=view&id=<?php echo $r_b_libro['link_portada']; ?>" alt="Card image cap">
                                                <br>
                                                <br>
                                                <center>
                                                    <button type="button" class="btn btn-danger" id="btn_agregar"><i class="fas fa-heart"></i></button>
                                                    <input type="hidden" id="librodd" value="<?php echo $link_libro; ?>">
                                                    <a href="lectura.php?libro=<?php echo $link_libro; ?>" class="btn btn-info">Leer Libro</a>
                                                    <div id="mostrar_noti"></div>
                                                </center>
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <h4><?php echo $r_b_libro['titulo']; ?></h4>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p><b>Programa de Estudio</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_programa['nombre']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Semestre</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_semestre['descripcion']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Unidad Didáctica</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_ud['descripcion']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Nro de Páginas</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_libro['paginas']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Autor</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_libro['autor']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Editorial</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_libro['editorial']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>ISBN</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_libro['isbn']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Edición</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_libro['edicion']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Tomo</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_libro['tomo']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Categoría</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_libro['tipo_libro']; ?></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><b>Temas Relacionados</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: <?php echo $r_b_libro['temas_relacionados']; ?></p>
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
