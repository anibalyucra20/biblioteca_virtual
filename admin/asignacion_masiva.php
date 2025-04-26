<?php
session_start();
include("../include/conexion.php");
include("../include/conexion_sispa.php");
include("../include/busquedas.php");
include("../include/busquedas_sispa.php");
include("../include/funciones.php");
//include("../include/verificar_sesion_admin.php");

/*if (!verificar_sesion($conexion) == 1) {
    echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('../index.php');
              </script>";
} else {
*/
$buscar_sesion = buscar_sesion($conexion, $_SESSION['id_sesion_biblioteca']);
$r_buscar_sesion = mysqli_fetch_array($buscar_sesion);
$id_usuario = $r_buscar_sesion['id_usuario'];

if ($r_buscar_sesion['tipo_acceso'] == 'docente' || $r_buscar_sesion['tipo_acceso'] == 'estudiante') {
    $b_usuario = buscarDocenteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
    $tipo_usuario = "docente";
} else {
    echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('../index.php');
              </script>";
}
$r_b_usuario = mysqli_fetch_array($b_usuario);

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

                                        <div class="col-md-9 mb-3">
                                            <form role="form" action="operaciones/registrar_asignacion.php" method="POST" enctype="multipart/form-data">
                                                <div class="col-md-12 mb-3">
                                                    <label for="validationCustom01">Programa de Estudios :</label>
                                                    <select name="id_programa" id="id_programa_m" class="form-control" required value="<?php echo $r_b_libro['id_programa_estudio']; ?>">
                                                        <option value=""></option>
                                                        <?php
                                                        $b_carreras = buscarCarreras($conexion_sispa);
                                                        while ($r_b_carreras = mysqli_fetch_array($b_carreras)) { ?>
                                                            <option value="<?php echo $r_b_carreras['id']; ?>" <?php if ($r_b_carreras['id'] == $r_b_libro['id_programa_estudio']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>><?php echo $r_b_carreras['nombre'] . " " . $r_b_carreras['plan_estudio']; ?></option>
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
                                                    <select name="id_unidad_didactica" id="id_unidad_didactica_m" class="form-control" required>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="validationCustom01">Palabra Clave :</label>
                                                    <input type="text" name="palabra_clave" id="palabra_clave" class="form-control">
                                                </div>
                                                <button type="button" class="btn btn-info" onclick="listar_libros();"><i class="fa fa-search"></i></button>
                                                <br>
                                                <br>
                                                <br>
                                                <div id="contenido_notificacion">

                                                </div>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Nro</th>
                                                            <th>Nombre del libro</th>
                                                            <th>Programas de estudios</th>
                                                            <th>semestre</th>
                                                            <th>Unidad Didáctica</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="contenido_libros_masiva">
                                                    </tbody>
                                                </table>
                                            </form>
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
            var ud = $('#id_unidad_didactica_m').val();
            var carr = $('#id_programa_m').val();
            var sem = $('#id_semestre_m').val();
            $.ajax({
                type: "POST",
                url: "operaciones/listar_ud.php",
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
    <script type="text/javascript">
        function listar_libros() {
            var ud = $('#id_unidad_didactica_m').val();
            var carr = $('#id_programa_m').val();
            var sem = $('#id_semestre_m').val();
            var palabra = $('#palabra_clave').val();
            if (ud == '' || carr == '' || sem == '' || palabra == '') {
                alert("falta seleccionar la unidad didactica y/o contenido");
            } else {
                $.ajax({
                    type: "POST",
                    url: "operaciones/listar_libros.php",
                    data: {
                        id_pe: carr,
                        id_sem: sem,
                        id_ud: ud,
                        palabra: palabra
                    },
                    success: function(r) {
                        $('#contenido_libros_masiva').html(r);
                    }
                });
            }
        }
    </script>
    <script type="text/javascript">
        function agregar_asignacion(pe = 0, sem = 0, ud = 0, libro = 0) {
            $.ajax({
                type: "POST",
                url: "operaciones/registrar_asignacion_masiva.php",
                data: {
                    id_pe: pe,
                    id_sem: sem,
                    id_ud: ud,
                    libro: libro
                },
                success: function(r) {
                    $('#contenido_notificacion').html(r);
                }
            });
        }
    </script>
</body>

</html>
<?php 
//}
