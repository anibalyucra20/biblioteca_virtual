<?php
session_start();
include("../include/conexion.php");
include("../include/conexion_sispa.php");
include("../include/busquedas.php");
include("../include/busquedas_sispa.php");
include("../include/funciones.php");
include("../include/verificar_sesion_admin.php");

if (!verificar_sesion($conexion) == 1) {
    echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('../index.php');
              </script>";
} else {

    $buscar_sesion = buscar_sesion($conexion, $_SESSION['id_sesion_biblioteca']);
    $r_buscar_sesion = mysqli_fetch_array($buscar_sesion);
    $id_usuario = $r_buscar_sesion['id_usuario'];

    if ($r_buscar_sesion['tipo_acceso'] == 'docente') {
        $b_usuario = buscarDocenteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
        $tipo_usuario = "docente";
    } else {
        echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('../index.php');
              </script>";
    }
    $r_b_usuario = mysqli_fetch_array($b_usuario);

    $libro = $_GET['libro'];
    $b_libro = buscar_libroByLinkPortada($conexion, $libro);
    $r_b_libro = mysqli_fetch_array($b_libro);
    $id_libro = $r_b_libro['id'];

?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <title>Biblioteca - IESTP HUANTA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="../images/favicon.ico">

        <!-- App css -->
        <link href="../plugins/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
        <link href="../pp/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../pp/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../pp/assets/css/theme.min.css" rel="stylesheet" type="text/css" />
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script>
            function confirmardelete() {
                var r = confirm("Estas Seguro de Eliminar la asignación?");
                if (r == true) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>
    </head>

    <body>

        <!-- Begin page -->
        <div id="layout-wrapper">
            <div class="main-content">

                <?php
                if ($r_b_usuario['id_cargo'] == 2) {
                    include "include/menu.php";
                } else {
                    include "include/mennu.php";
                }
                ?>
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <a href="reasignar_libro.php" class="btn btn-danger">Regresar</a>
                                            <h5 class="card-title mb-0">Este libro se encuentra asignado a :</h5>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustom01">Portada :</label>
                                                <iframe src="https://drive.google.com/file/d/<?php echo $r_b_libro['link_portada']; ?>/preview" frameborder="none" style="width:100%; height:400px; overflow: hidden;" scrolling="no"></iframe>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target=".bd-example-modal-lg">+</button>
                                                <table class="table col-12">
                                                    <thead>
                                                        <tr>
                                                            <th>Nro</th>
                                                            <th>Programa de Estudios</th>
                                                            <th>Semestre</th>
                                                            <th>Unidad Didáctica</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $b_asignaciones = buscar_asignacionByIdLibro($conexion, $id_libro);
                                                        $cont = 0;
                                                        while ($rb_asignaciones = mysqli_fetch_array($b_asignaciones)) {
                                                            $cont++;
                                                            $b_pe = buscarCarrerasById($conexion_sispa, $rb_asignaciones['id_programa_estudio']);
                                                            $rb_pe = mysqli_fetch_array($b_pe);

                                                            $b_sem = buscarSemestreById($conexion_sispa, $rb_asignaciones['id_semestre']);
                                                            $rb_sem = mysqli_fetch_array($b_sem);

                                                            $b_ud = buscarUdById($conexion_sispa, $rb_asignaciones['id_unidad_didactica']);
                                                            $rb_ud = mysqli_fetch_array($b_ud);
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $cont; ?></td>
                                                                <td><?php echo $rb_pe['nombre']." ".$rb_pe['plan_estudio']; ?></td>
                                                                <td><?php echo $rb_ud['descripcion']; ?></td>
                                                                <td><?php echo $rb_ud['descripcion']; ?></td>
                                                                <td><a title="Eliminar" class="btn btn-danger" href="operaciones/eliminar_asignacion.php?data=<?php echo $libro; ?>&data2=<?php echo $rb_asignaciones['id']; ?>" onclick="return confirmardelete();"><i class="fa fa-trash"></i></a></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!---- INICIO MODAL-->
                                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title h4" id="myLargeModalLabel">Registrar Nueva Asignación de Libro</h5>
                                                            <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="operaciones/registrar_asignacion.php" method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="data" value="<?php echo $id_libro; ?>">
                                                                <input type="hidden" name="data2" value="<?php echo $libro; ?>">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Programa de Estudios :</label>
                                                                    <select name="id_programa" id="id_programa_m" class="form-control" required value="<?php echo $r_b_libro['id_programa_estudio']; ?>">
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $b_carreras = buscarCarreras($conexion_sispa);
                                                                        while ($r_b_carreras = mysqli_fetch_array($b_carreras)) { ?>
                                                                            <option value="<?php echo $r_b_carreras['id']; ?>" <?php if ($r_b_carreras['id'] == $r_b_libro['id_programa_estudio']) {
                                                                                                                                    echo "selected";
                                                                                                                                } ?>><?php echo $r_b_carreras['nombre']." ".$r_b_carreras['plan_estudio']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Semestre :</label>
                                                                    <select name="id_semestre" id="id_semestre_m" class="form-control" required value="<?php echo $r_b_libro['id_semestre']; ?>">
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $b_semestre = buscarSemestre($conexion_sispa);
                                                                        while ($r_b_semestre = mysqli_fetch_array($b_semestre)) { ?>
                                                                            <option value="<?php echo $r_b_semestre['id']; ?>" <?php if ($r_b_semestre['id'] == $r_b_libro['id_semestre']) {
                                                                                                                                    echo "selected";
                                                                                                                                } ?>><?php echo $r_b_semestre['descripcion']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="validationCustom01">Unidad Didáctica :</label>
                                                                    <select name="id_unidad_didactica" id="id_unidad_didactica_m" class="form-control" required value="<?php echo $r_b_libro['id_unidad_didactica']; ?>">
                                                                        <option value=""></option>
                                                                    </select>
                                                                </div>
                                                                <button class="btn btn-primary waves-effect waves-light" type="submit">Registrar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!---- FIN MODAL -->
                                        </div>
                                    </div>
                                    <!--end card body-->
                                </div><!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end page title -->
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <?php include "../include/footer.php"; ?>
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        <!-- jQuery  -->
        <script src="../pp/assets/js/jquery.min.js"></script>
        <script src="../pp/assets/js/bootstrap.bundle.min.js"></script>
        <script src="../pp/assets/js/waves.js"></script>
        <script src="../pp/assets/js/simplebar.min.js"></script>

        <script src="../pp/assets/pages/validation-demo.js"></script>

        <script src="../plugins/dropify/dropify.min.js"></script>

        <!-- Init js-->
        <script src="../pp/assets/pages/fileuploads-demo.js"></script>
        <!-- App js -->
        <script src="../pp/assets/js/theme.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                listar_uds();
                $('#id_programa_m').change(function() {
                    listar_uds();
                });
                $('#id_semestre_m').change(function() {
                    listar_uds();
                });

            })
        </script>
        <script type="text/javascript">
            function listar_uds() {
                var ud = $('#id_ud_m').val();
                var carr = $('#id_programa_m').val();
                var sem = $('#id_semestre_m').val();
                $.ajax({
                    type: "POST",
                    url: "operaciones/listar_ud_edit.php",
                    data: {
                        id_pe: carr,
                        id_sem: sem,
                        id_ud: ud
                    },
                    success: function(r) {
                        $('#id_unidad_didactica_m').html(r);
                    }
                });
            }
        </script>
    </body>

    </html>
<?php }
