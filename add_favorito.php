<?php
session_start();
include("include/conexion.php");
include("include/conexion_sispa.php");
include("include/busquedas.php");
include("include/busquedas_sispa.php");
include("include/funciones.php");
include("include/verificar_sesion.php");


$link_libro = $_POST['libro'];
$b_libro = buscar_libroByLinkPortada($conexion, $link_libro);
$r_b_libro = mysqli_fetch_array($b_libro);

$buscar_sesion = buscar_sesion($conexion, $_SESSION['id_sesion_biblioteca']);
$r_buscar_sesion = mysqli_fetch_array($buscar_sesion);

if ($r_buscar_sesion['tipo_acceso'] == 'docente') {
    $b_usuario = buscarDocenteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
    $tipo_usuario = "docente";
} elseif ($r_buscar_sesion['tipo_acceso'] == 'estudiante') {
    $b_usuario = buscarEstudianteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
    $tipo_usuario = "estudiante";
}

$id_libro = $r_b_libro['id'];
$id_sesion = $_SESSION['id_sesion_biblioteca'];
$id_usuario = $r_buscar_sesion['id_usuario'];
$fecha_hora = date("Y-m-d H:i:s");

$b_favoritos = buscar_favoritosByidLibroUsuTipo($conexion, $id_libro, $id_usuario, $tipo_usuario);
$cont_favoritos = mysqli_num_rows($b_favoritos);

if ($cont_favoritos>0) {
    $r_b_favoritos = mysqli_fetch_array($b_favoritos);
    $id_fav = $r_b_favoritos['id'];
    $consulta = "DELETE FROM libros_favoritos WHERE id='$id_fav'";
    $delete = mysqli_query($conexion,$consulta);

    $c_registrar = "INSERT INTO libros_favoritos (id_usuario, tipo_usuario, id_libro, fecha_hora) VALUES ('$id_usuario','$tipo_usuario','$id_libro','$fecha_hora')";
    $registrar = mysqli_query($conexion,$c_registrar);
}else{
    $c_registrar = "INSERT INTO libros_favoritos (id_usuario, tipo_usuario, id_libro, fecha_hora) VALUES ('$id_usuario','$tipo_usuario','$id_libro','$fecha_hora')";
    $registrar = mysqli_query($conexion,$c_registrar);
}





echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
<strong>Agregado a Favoritos</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
</button>
</div>';











?>

