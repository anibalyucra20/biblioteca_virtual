<?php
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

    //recibir valores para la busqueda
    if (isset($_GET['titulo'])) {
        $titulo = $_GET['titulo'];
    } else {
        $titulo = '';
    }
    if (isset($_GET['autor'])) {
        $autor = $_GET['autor'];
    } else {
        $autor = '';
    }
    if (isset($_GET['temas'])) {
        $temas = $_GET['temas'];
    } else {
        $temas = '';
    }
    if (isset($_GET['programa_estudio'])) {
        $programa_estudio = $_GET['programa_estudio'];
    } else {
        $programa_estudio = 'TODOS';
    }
    if (isset($_GET['semestre'])) {
        $semestre = $_GET['semestre'];
    } else {
        $semestre = 'TODOS';
    }
    if (isset($_GET['unidad_didactica'])) {
        $unidad_didactica = $_GET['unidad_didactica'];
    } else {
        $unidad_didactica = 'TODOS';
    }

    $envio_get = "&titulo=" . $titulo . "&autor=" . $autor . "&temas=" . $temas . "&programa_estudio=" . $programa_estudio . "&semestre=" . $semestre . "&unidad_didactica=" . $unidad_didactica;

    $validar = 0;
    $consulta_e = "SELECT * FROM asignacion_libro ";
    $condicion_busqueda = "";

    if (!$titulo == '') {
        $condicion_busqueda .= "WHERE titulo LIKE '%" . $titulo . "%'";
        $validar++;
    }

    if ($autor != '' && $validar > 0) {
        $condicion_busqueda .= " AND autor LIKE '%" . $autor . "%'";
        $validar++;
    } elseif ($autor != '' && $validar == 0) {
        $condicion_busqueda .= "WHERE autor LIKE '%" . $autor . "%'";
        $validar++;
    }

    if ($temas != '' && $validar > 0) {
        $condicion_busqueda .= " AND temas_relacionados LIKE '%" . $temas . "%'";
        $validar++;
    } elseif ($temas != '' && $validar == 0) {
        $condicion_busqueda .= "WHERE temas_relacionados LIKE '%" . $temas . "%'";
        $validar++;
    }

    if ($programa_estudio != 'TODOS' && $validar > 0) {
        $condicion_busqueda .= " AND id_programa_estudio=" . $programa_estudio;
        $validar++;
    } elseif ($programa_estudio != 'TODOS' && $validar == 0) {
        $condicion_busqueda .= " WHERE id_programa_estudio=" . $programa_estudio;
        $validar++;
    }

    if ($semestre != 'TODOS' && $validar > 0) {
        $condicion_busqueda .= " AND id_semestre=" . $semestre;
        $validar++;
    } elseif ($semestre != 'TODOS' && $validar == 0) {
        $condicion_busqueda .= " WHERE id_semestre=" . $semestre;
        $validar++;
    }

    if ($unidad_didactica != 'TODOS' && $validar > 0) {
        $condicion_busqueda .= " AND id_unidad_didactica=" . $unidad_didactica;
        $validar++;
    } elseif ($unidad_didactica != 'TODOS' && $validar == 0) {
        $condicion_busqueda .= " WHERE id_unidad_didactica=" . $unidad_didactica;
        $validar++;
    }

    $consulta_eeee = $consulta_e . $condicion_busqueda;



    $buscar_sesion = buscar_sesion($conexion, $_SESSION['id_sesion_biblioteca']);
    $r_buscar_sesion = mysqli_fetch_array($buscar_sesion);

    if ($r_buscar_sesion['tipo_acceso'] == 'docente') {
        $b_usuario = buscarDocenteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
        $tipo_usuario = "docente";
        $r_b_usuario = mysqli_fetch_array($b_usuario);
        $id_programa_estudios_sesion = $r_b_usuario['id_programa_estudio'];
    } elseif ($r_buscar_sesion['tipo_acceso'] == 'estudiante') {
        $b_usuario = buscarEstudianteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
        $tipo_usuario = "estudiante";
        $r_b_usuario = mysqli_fetch_array($b_usuario);
        $id_programa_estudios_sesion = $r_b_usuario['id_programa_estudios'];
    } else {
        echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('index.php');
              </script>";
    }




    //https://www.youtube.com/watch?v=tRUg2fSLRJo

    $ejec = mysqli_query($conexion, $consulta_eeee);
    $cont = mysqli_num_rows($ejec);

    if ($cont > 0) {

        $total_lib = $cont;
        $articulos_por_pagina = 8;
        $paginas = ceil($total_lib / $articulos_por_pagina);

        $iniciar = ($_GET['pagina'] - 1) * $articulos_por_pagina;


        if (!isset($_GET['pagina'])) header('location:biblioteca.php?pagina=1&programa_estudio=' . $id_programa_estudios_sesion);
        if ($_GET['pagina'] > $paginas || $_GET['pagina'] < 1) header('location:biblioteca.php?pagina=1&programa_estudio=' . $id_programa_estudios_sesion);

        $buscar = "SELECT * FROM asignacion_libro " . $condicion_busqueda . " LIMIT $iniciar, $articulos_por_pagina";
        $ejec_buscar = mysqli_query($conexion, $buscar);


        // INICIO PAGINACION ==================================================================================================
        $paginacion = "";
        $paginacion .= '<li class="page-item';
        if ($_GET['pagina'] == 1) {
            $paginacion .= " disabled";
        }
        $paginacion .= ' "><a class="page-link" href="biblioteca.php?pagina=1' . $envio_get . '">Inicio</a></li>';

        $paginacion .= '<li class="page-item ';
        if ($_GET['pagina'] == 1) {
            $paginacion .= "disabled";
        }
        $paginacion .= '"><a class="page-link" href="biblioteca.php?pagina=';
        $paginacion .= $_GET['pagina'] - 1;
        $paginacion .= $envio_get . '">Anterior</a></li>';



        if ($_GET['pagina'] > 4) {
            $iin = $_GET['pagina'] - 2;
        } else {
            $iin = 1;
        }

        for ($i = $iin; $i <= $paginas; $i++) {
            if (($paginas - 7) > $i) {
                $n_n = $iin + 5;
            }
            if ($i == $n_n) {
                $nn = $_GET["pagina"] + 1;
                $paginacion .= '<li class="page-item"><a class="page-link" href="biblioteca.php?pagina=' . $nn . $envio_get . '">...</a></li>';
                $i = $paginas - 2;
            }
            $paginacion .= '<li class="page-item ';
            if ($_GET['pagina'] == $i) {
                $paginacion .= "active";
            }
            $paginacion .= '" ><a class="page-link" href="biblioteca.php?pagina=';
            $paginacion .= $i;
            $paginacion .= $envio_get . ' ">' . $i . '</a></li>';
        }

        $paginacion .= '<li class="page-item ';
        if ($_GET['pagina'] >= $paginas) {
            $paginacion .= "disabled";
        }
        $paginacion .= '"><a class="page-link" href="biblioteca.php?pagina=';
        $paginacion .=  $_GET['pagina'] + 1;
        $paginacion .= $envio_get . '">Siguiente</a></li>';

        $paginacion .= '<li class="page-item ';
        if ($_GET['pagina'] >= $paginas) {
            $paginacion .= "disabled";
        }
        $paginacion .= '"><a class="page-link" href="biblioteca.php?pagina=' . $paginas . $envio_get . '">Final</a></li>';



        // FIN PAGINACION ===================================================================================================

    }








?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <title>Biblioteca - IESTP HUANTA</title>
        <?php include "include/header.php"; ?>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    </head>

    <body>
        <?php //echo $_GET['titulo']; 
        ?>
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
                                    <div id="accordion" class="custom-accordion mb-4">
                                        <div class="card mb-0">
                                            <div class="card-header" id="headingTwo">
                                                <h5 class="m-0 font-size-15">
                                                    <a class="collapsed d-block pt-2 pb-2 text-dark" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Búsqueda <span class="fas fa-search"></span> <span class="float-right"><i class="mdi mdi-chevron-down accordion-arrow"></i></span>
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="card-body">
                                                    <form action="" method="GET">
                                                        <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>">
                                                        <div class="form-row">
                                                            <div class="col-md-12 content-align-center">
                                                                <h4>Búsqueda</h4>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Por Título de Libro:</label>
                                                                <input type="text" class="form-control" name="titulo" value="<?php echo $titulo; ?>">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Por Autor:</label>
                                                                <input type="text" class="form-control" name="autor" value="<?php echo $autor; ?>">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Por Temas:</label>
                                                                <input type="text" class="form-control" name="temas" value="<?php echo $temas; ?>">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Programa de Estudios</label>
                                                                <select name="programa_estudio" id="programa_estudio_m" class="form-control" value="<?php echo $programa_estudio; ?>">
                                                                    <option value="TODOS">TODOS</option>
                                                                    <?php $b_carreras = buscarCarreras($conexion_sispa);
                                                                    while ($r_b_carreras = mysqli_fetch_array($b_carreras)) { ?>
                                                                        <option value="<?php echo $r_b_carreras['id']; ?>" <?php if ($programa_estudio == $r_b_carreras['id']) {
                                                                                                                                echo "selected";
                                                                                                                            } ?>><?php echo $r_b_carreras['nombre']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Semestre</label>
                                                                <select name="semestre" id="semestre_m" class="form-control" value="<?php echo $semestre; ?>">
                                                                    <option value="TODOS">TODOS</option>
                                                                    <?php
                                                                    $b_semestre = buscarSemestre($conexion_sispa);
                                                                    while ($r_b_semestre = mysqli_fetch_array($b_semestre)) { ?>
                                                                        <option value="<?php echo $r_b_semestre['id']; ?>" <?php if ($semestre == $r_b_semestre['id']) {
                                                                                                                                echo "selected";
                                                                                                                            } ?>><?php echo $r_b_semestre['descripcion']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Unidad Didáctica</label>
                                                                <select name="unidad_didactica" id="unidad_didactica_m" class="form-control" value="<?php echo $unidad_didactica; ?>">
                                                                    <option value="TODOS">TODOS</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label for=""></label><br>
                                                                <button class="btn btn-primary waves-effect waves-light" type="submit">Buscar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($cont > 0) { ?>

                            <div id="contenido"></div>
                            <div class="container d-flex justify-content-center">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <div class="row">
                                            <?php echo $paginacion; ?>
                                        </div>
                                    </ul>
                                </nav>

                            </div>

                            <div class="row">
                                <?php
                                while ($res_bus = mysqli_fetch_array($ejec_buscar)) {

                                    $id_material = $res_bus['id_libro'];
                                    $b_material = buscar_libroById($conexion, $id_material);
                                    $rb_material = mysqli_fetch_array($b_material);

                                    $b_programa = buscarCarrerasById($conexion_sispa, $res_bus['id_programa_estudio']);
                                    $r_b_programa = mysqli_fetch_array($b_programa);

                                    $b_semestre = buscarSemestreById($conexion_sispa, $res_bus['id_semestre']);
                                    $r_b_semestre = mysqli_fetch_array($b_semestre);

                                    $b_ud = buscarUdById($conexion_sispa, $res_bus['id_unidad_didactica']);
                                    $r_b_ud = mysqli_fetch_array($b_ud);
                                ?>
                                    <div class="card col-lg-3 col-md-3 col-sm-6 mb-2">
                                        <iframe src="https://drive.google.com/file/d/<?php echo $rb_material['link_portada']; ?>/preview" frameborder="none" style="width:100%; height:500px; overflow: hidden; " scrolling="no"></iframe>
                                            <embed src="https://drive.google.com/file/d/<?php echo $rb_material['link_portada']; ?>/preview" width="500" height="375" type="application/pdf">
                                        <div class="card-body">
                                            <h5 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"><?php echo $res_bus['titulo']; ?></h5>
                                            <p class="card-text"><?php echo $r_b_programa['nombre'] . ' - ' . $r_b_semestre['descripcion']; ?></p>
                                            <p class="card-text"><?php echo $r_b_ud['descripcion']; ?></p>
                                            <p class="card-text">Autor: <?php echo $res_bus['autor']; ?></p>
                                            <center><a href="detalle.php?libro=<?php echo $rb_material['link_portada'] ?>" class="btn btn-info">Ver</a></center>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- end page title -->
                            <div class="container d-flex justify-content-center">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <div class="row">
                                            <?php echo $paginacion; ?>
                                        </div>
                                    </ul>
                                </nav>

                            </div>


                        <?php } else { ?>
                            <h2>No se Encontró Coincidencias Con la Búsqueda Realizada</h2>

                        <?php } ?>




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

                $('#programa_estudio_m').change(function() {
                    listar_uds();
                });
                $('#semestre_m').change(function() {
                    listar_uds();
                });
                listar_uds();
            })
        </script>
        <script type="text/javascript">
            function listar_uds() {
                var carr = $('#programa_estudio_m').val();
                var sem = $('#semestre_m').val();
                var uddd = '<?php echo $unidad_didactica; ?>';
                $.ajax({
                    type: "POST",
                    url: "include/listar_ud.php",
                    data: {
                        id_pe: carr,
                        id_sem: sem,
                        id_ud: uddd
                    },
                    success: function(r) {
                        $('#unidad_didactica_m').html(r);
                    }
                });
            }
        </script>

    </body>

    </html>
<?php }
