<?php


// --------------------- INICIO DE PAGINA ---------------

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
    $id_usuario = $r_buscar_sesion['id_usuario'];

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

    /*if (!verificar_sesion($conexion)) {
    echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('login/');
              </script>";
}else {*/
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <title>Biblioteca - IESTP HUANTA</title>
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
                                    <h4 class="mb-0 font-size-18">Últimos Libros Leídos <i class="fas fa-book-open"></i> </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $b_lecturas = buscar_4lecturas_invert($conexion, $id_usuario, $tipo_usuario);
                            while ($r_b_lecturas = mysqli_fetch_array($b_lecturas)) {
                                $b_libro = buscar_libroById($conexion, $r_b_lecturas['id_libro']);
                                $r_b_libro = mysqli_fetch_array($b_libro);

                                $b_programa = buscarCarrerasById($conexion_sispa, $r_b_libro['id_programa_estudio']);
                                $r_b_programa = mysqli_fetch_array($b_programa);

                                $b_semestre = buscarSemestreById($conexion_sispa, $r_b_libro['id_semestre']);
                                $r_b_semestre = mysqli_fetch_array($b_semestre);

                                $b_ud = buscarUdById($conexion_sispa, $r_b_libro['id_unidad_didactica']);
                                $r_b_ud = mysqli_fetch_array($b_ud);
                            ?>
                                <div class="card col-lg-3 col-md-3 col-sm-6 m-0">
                                    <img class="card-img-top fluid" src="https://drive.google.com/uc?export=view&id=<?php echo $r_b_libro['link_portada']; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"><?php echo $r_b_libro['titulo']; ?></h5>
                                        <p class="card-text"><?php echo $r_b_programa['nombre'] . ' - S-' . $r_b_semestre['descripcion']; ?></p>
                                        <p class="card-text"><?php echo $r_b_ud['descripcion']; ?></p>
                                        <p class="card-text">Autor: <?php echo $r_b_libro['autor']; ?></p>
                                        <center><a href="detalle.php?libro=<?php echo $r_b_libro['link_portada'] ?>" class="btn btn-info">Ver</a></center>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Mis Libros Favoritos <i class="fas fa-heart"></i> </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                                $b_4ultimos_favoritos = buscar_4ultimos_favoritos($conexion, $id_usuario, $tipo_usuario);
                                while ($r_b_favoritos = mysqli_fetch_array($b_4ultimos_favoritos)) {
                                    $b_libro = buscar_libroById($conexion, $r_b_favoritos['id_libro']);
                                    $r_b_libro = mysqli_fetch_array($b_libro);

                                    $b_programa = buscarCarrerasById($conexion_sispa, $r_b_libro['id_programa_estudio']);
                                    $r_b_programa = mysqli_fetch_array($b_programa);

                                    $b_semestre = buscarSemestreById($conexion_sispa, $r_b_libro['id_semestre']);
                                    $r_b_semestre = mysqli_fetch_array($b_semestre);

                                    $b_ud = buscarUdById($conexion_sispa, $r_b_libro['id_unidad_didactica']);
                                    $r_b_ud = mysqli_fetch_array($b_ud);
                            ?>
                                <div class="card col-lg-3 col-md-3 col-sm-6 m-0">
                                    <img class="card-img-top fluid" src="https://drive.google.com/uc?export=view&id=<?php echo $r_b_libro['link_portada']; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"><?php echo $r_b_libro['titulo']; ?></h5>
                                        <p class="card-text"><?php echo $r_b_programa['nombre'] . ' - S-' . $r_b_semestre['descripcion']; ?></p>
                                        <p class="card-text"><?php echo $r_b_ud['descripcion']; ?></p>
                                        <p class="card-text">Autor: <?php echo $r_b_libro['autor']; ?></p>
                                        <center><a href="detalle.php?libro=<?php echo $r_b_libro['link_portada'] ?>" class="btn btn-info">Ver</a></center>
                                    </div>
                                </div>
                            <?php } ?>
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

<?php
}

//}