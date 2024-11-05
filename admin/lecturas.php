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
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <span>Filtrar por Tipo de Usuario</span>
                                                <select name="filtro_usuario" id="filtro_usuario" class="form-control">
                                                    <option value="">TODOS</option>
                                                    <option value="docente">DOCENTE</option>
                                                    <option value="estudiante">ESTUDIANTE</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <span>Filtrar por Programa de Estudio</span>
                                                <select name="filtro_pe" id="filtro_pe" class="form-control">
                                                    <option value="">TODOS</option>
                                                    <option value="DISEÑO Y PROGRAMACIÓN WEB">DISEÑO Y PROGRAMACIÓN WEB</option>
                                                    <option value="ENFERMERÍA TÉCNICA">ENFERMERÍA TÉCNICA</option>
                                                    <option value="INDUSTRIAS ALIMENTARIAS">INDUSTRIAS ALIMENTARIAS</option>
                                                    <option value="MECATRONICA AUTOMOTRIZ">MECATRONICA AUTOMOTRIZ</option>
                                                    <option value="PRODUCCION AGROPECUARIA">PRODUCCION AGROPECUARIA</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <span>Filtrar por Fecha</span>
                                                <div class="row">
                                                <input type="date" id="fecha_inicio" class="form-control col-4" value="2023-01-01"> - 
                                                <input type="date" id="fecha_fin" class="form-control col-4" value="<?php echo date("Y-m-d"); ?>">
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>
                                        <table id="example" class="table dt-responsive " width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Nro</th>
                                                    <th>Usuario</th>
                                                    <th>Tipo de Usuario</th>
                                                    <th>Programa de Estudios</th>
                                                    <th>Fecha y Hora de Lectura</th>
                                                    <th>Libro de Lectura</th>
                                                    <!--<th>imagen</th>-->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $b_lecturas = buscar_lecturas($conexion);
                                                $cont = 0;
                                                while ($r_b_lecturas = mysqli_fetch_array($b_lecturas)) {
                                                    $cont++;
                                                    $id_sesion = $r_b_lecturas['id_sesion'];
                                                    $b_sesion = buscar_sesion($conexion, $id_sesion);
                                                    $rb_sesion = mysqli_fetch_array($b_sesion);

                                                    if ($rb_sesion['tipo_acceso'] == 'docente') {
                                                        $b_usuario = buscarDocenteById($conexion_sispa, $rb_sesion['id_usuario']);
                                                        $r_b_usuario = mysqli_fetch_array($b_usuario);
                                                        $buscar_pe = buscarCarrerasById($conexion_sispa, $r_b_usuario['id_programa_estudio']);
                                                        $r_b_pe = mysqli_fetch_array($buscar_pe);
                                                    } else {
                                                        $b_usuario = buscarEstudianteById($conexion_sispa, $rb_sesion['id_usuario']);
                                                        $r_b_usuario = mysqli_fetch_array($b_usuario);
                                                        $buscar_pe = buscarCarrerasById($conexion_sispa, $r_b_usuario['id_programa_estudios']);
                                                        $r_b_pe = mysqli_fetch_array($buscar_pe);
                                                    }

                                                    $b_libro = buscar_libroById($conexion, $r_b_lecturas['id_libro']);
                                                    $rb_libro = mysqli_fetch_array($b_libro);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $cont; ?></td>
                                                        <td><?php echo $r_b_usuario['apellidos_nombres']; ?></td>
                                                        <td><?php echo $rb_sesion['tipo_acceso']; ?></td>
                                                        <td><?php echo $r_b_pe['nombre']; ?></td>
                                                        <td><?php echo $r_b_lecturas['fecha_hora']; ?></td>
                                                        <td><?php echo $rb_libro['titulo']; ?></td>
                                                        <!--<td><iframe src="https://drive.google.com/file/d/<?php echo $rb_libro['link_portada']; ?>/preview" frameborder="none" style="width:80%; height:100px; overflow: hidden;" scrolling="no"></iframe></td>-->
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
        <script>
            $(document).ready(function() {
                var table = $('#example').DataTable();

                // Custom filter for tipo de usuario
                $('#filtro_usuario').on('change', function() {
                    var filtro = $(this).val();
                    table.column(2).search(filtro).draw();
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var table = $('#example').DataTable();

                // Custom filter for Programa de Estudios
                $('#filtro_pe').on('change', function() {
                    var filtro = $(this).val();
                    table.column(3).search(filtro).draw();
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var table = $('#example').DataTable();

                // Filtro personalizado para el rango de fechas
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        // Índice de la columna que contiene la fecha (ajusta según tu tabla)
                        var columnaFechaIndex = 4;

                        // Obtener las fechas del rango
                        var fechaInicio = $('#fecha_inicio').val();
                        var fechaFin = $('#fecha_fin').val();

                        // Parsear la fecha de la columna en el formato correcto (YYYY-MM-DD)
                        var fechaColumna = data[columnaFechaIndex];
                        var fecha = new Date(fechaColumna); // Asegúrate de que la fecha esté en formato compatible (YYYY-MM-DD)

                        // Convertir las fechas del rango en objetos Date para la comparación
                        if (fechaInicio) fechaInicio = new Date(fechaInicio);
                        if (fechaFin) fechaFin = new Date(fechaFin);

                        // Filtrar por el rango de fechas
                        if ((fechaInicio && fecha < fechaInicio) || (fechaFin && fecha > fechaFin)) {
                            return false; // Excluir la fila si no está en el rango
                        }
                        return true; // Incluir la fila si está en el rango
                    }
                );

                // Actualizar la tabla cuando cambian las fechas de filtro
                $('#fecha_inicio, #fecha_fin').on('change', function() {
                    table.draw();
                });
            });
        </script>
    </body>

    </html>

<?php }
