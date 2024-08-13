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

        <!-- Plugins css -->
        <link href="../plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="../plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="../plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
        <link href="../plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="../pp/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../pp/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../pp/assets/css/theme.min.css" rel="stylesheet" type="text/css" />
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
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Reporte de Lecturas</h4>
                                        <table id="example" class="table dt-responsive " width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Nro</th>
                                                    <th>Usuario</th>
                                                    <th>Tipo de Usuario</th>
                                                    <th>Programa de Estudios</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $b_docentes = buscarDocenteActivos($conexion);
                                                $cont = 0;
                                                while ($r_b_docentes = mysqli_fetch_array($b_docentes)) {
                                                    $cont++;
                                                    $buscar_pe = buscarCarrerasById($conexion_sispa, $r_b_docentes['id_programa_estudio']);
                                                    $r_b_pe = mysqli_fetch_array($buscar_pe);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $cont; ?></td>
                                                        <td><?php echo $r_b_docentes['apellidos_nombres']; ?></td>
                                                        <td>Docente</td>
                                                        <td><?php echo $r_b_pe['nombre']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php
                                                $b_estudiante = buscarEstudiante($conexion);
                                                $cont = 0;
                                                while ($r_b_estudiante = mysqli_fetch_array($b_estudiante)) {
                                                    $cont++;
                                                    $buscar_pe = buscarCarrerasById($conexion_sispa, $r_b_estudiante['id_programa_estudios']);
                                                    $r_b_pe = mysqli_fetch_array($buscar_pe);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $cont; ?></td>
                                                        <td><?php echo $r_b_estudiante['apellidos_nombres']; ?></td>
                                                        <td>Estudiante</td>
                                                        <td><?php echo $r_b_pe['nombre']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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

        <!-- third party js -->
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../plugins/datatables/dataTables.bootstrap4.js"></script>
        <script src="../plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>
        <script src="../plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="../plugins/datatables/buttons.html5.min.js"></script>
        <script src="../plugins/datatables/buttons.flash.min.js"></script>
        <script src="../plugins/datatables/buttons.print.min.js"></script>
        <script src="../plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="../plugins/datatables/dataTables.select.min.js"></script>
        <script src="../plugins/datatables/pdfmake.min.js"></script>
        <script src="../plugins/datatables/vfs_fonts.js"></script>
        <!-- third party js ends -->

        <!-- Datatables init -->
        <script src="../pp/assets/pages/datatables-demo.js"></script>

        <!-- App js -->
        <script src="../pp/assets/js/theme.js"></script>

        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    "language": {
                        "processing": "Procesando...",
                        "lengthMenu": "Mostrar _MENU_ registros",
                        "zeroRecords": "No se encontraron resultados",
                        "emptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
                        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "search": "Buscar:",
                        "infoThousands": ",",
                        "loadingRecords": "Cargando...",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                    }
                });

            });
        </script>
    </body>

    </html>

<?php }
