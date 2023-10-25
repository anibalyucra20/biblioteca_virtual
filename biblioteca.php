<?php
//https://www.youtube.com/watch?v=tRUg2fSLRJo
include "include/conexion.php";
$bbb = "SELECT * FROM libros";
$ejec = mysqli_query($conexion, $bbb);
$cont = mysqli_num_rows($ejec);


$total_lib = $cont;
$articulos_por_pagina = 8;
$paginas = ceil($total_lib / $articulos_por_pagina);

$iniciar = ($_GET['pagina'] - 1) * $articulos_por_pagina;


if (!isset($_GET['pagina'])) header('location:biblioteca.php?pagina=1');
if ($_GET['pagina'] > $paginas || $_GET['pagina'] < 1) header('location:biblioteca.php?pagina=1');

$buscar = "SELECT * FROM libros LIMIT $iniciar, $articulos_por_pagina";
$ejec_buscar = mysqli_query($conexion, $buscar);


// INICIO PAGINACION ==================================================================================================
$paginacion = "";
$paginacion .= '<li class="page-item';
if ($_GET['pagina'] == 1) {
    $paginacion .= " disabled";
}
$paginacion .= ' "><a class="page-link" href="biblioteca.php?pagina=1">Inicio</a></li>';

$paginacion .= '<li class="page-item ';
if ($_GET['pagina'] == 1) {
    $paginacion .= "disabled";
}
$paginacion .= '"><a class="page-link" href="biblioteca.php?pagina=';
$paginacion .= $_GET['pagina'] - 1;
$paginacion .= '">Anterior</a></li>';



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
        $paginacion .= '<li class="page-item"><a class="page-link" href="biblioteca.php?pagina=' . $nn . '">...</a></li>';
        $i = $paginas - 2;
    }
    $paginacion .= '<li class="page-item ';
    if ($_GET['pagina'] == $i) {
        $paginacion .= "active";
    }
    $paginacion .= '" ><a class="page-link" href="biblioteca.php?pagina=';
    $paginacion .= $i;
    $paginacion .= ' ">' . $i . '</a></li>';
}

$paginacion .= '<li class="page-item ';
if ($_GET['pagina'] >= $paginas) {
    $paginacion .= "disabled";
}
$paginacion .= '"><a class="page-link" href="biblioteca.php?pagina=';
$paginacion .=  $_GET['pagina'] + 1;
$paginacion .= '">Siguiente</a></li>';

$paginacion .= '<li class="page-item ';
if ($_GET['pagina'] >= $paginas) {
    $paginacion .= "disabled";
}
$paginacion .= '"><a class="page-link" href="biblioteca.php?pagina=' . $paginas . '">Final</a></li>';



// FIN PAGINACION ===================================================================================================


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Biblioteca - IESTP HUANTA</title>
    <?php include "include/header.php"; ?>
    <style>
        .card-img-top{
            width: 100%;
            height: 90%;
            object-fit: cover;
        }

    </style>
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
                                <div class="card-body">
                                    <form action="">
                                        <div class="form-row">
                                            <div class="col-md-12 content-align-center">
                                                <h4>Busqueda</h4>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Por Título de Libro:</label>
                                                <input type="text" class="form-control" name="titulo">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Por Autor:</label>
                                                <input type="text" class="form-control" name="autor">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Por Temas:</label>
                                                <input type="text" class="form-control" name="temas">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Programa de Estudios</label>
                                                <select name="programa_estudio" id="programa_estudio" class="form-control">
                                                    <option value="todos">TODOS</option>
                                                    <option value="1">DISEÑO Y PROGRAMACIÓN WEB</option>
                                                    <option value="2">ENFERMERÍA TÉCNICA</option>
                                                    <option value="3">INDUSTRIAS ALIMENTARIAS</option>
                                                    <option value="4">MECATRÓNICA AUTOMOTRIZ</option>
                                                    <option value="5">PRODUCCIÓN AGROPECUARIA</option>
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
                        ?>
                                <div class="card col-lg-3 col-md-4 col-sm-6 m-2">
                                    <img class="card-img-top" src="img_libro/<?php echo $res_bus['ruta_portada'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"><?php echo $res_bus['titulo']; ?></h5>
                                        <p class="card-text"><?php echo $res_bus['id_programa_estudio']; ?></p>
                                        <p class="card-text">Autor: Autor del libro</p>
                                        <center><a href="detalle.php" class="btn btn-info">Ver</a></center>
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