<?php
include("../include/conexion.php");
include("../include/conexion_sispa.php");
include("../include/busquedas.php");
include("../include/busquedas_sispa.php");

$id_pe = $_POST['id_pe'];
$id_sem = $_POST['id_sem'];
$id_ud = $_POST['id_ud'];

$ejec_cons = buscarUdByCarSem($conexion_sispa, $id_pe, $id_sem);

$cadena = '<option value="TODOS">TODOS</option>';
$info = "";
while ($mostrar = mysqli_fetch_array($ejec_cons)) {

        if ($id_ud==$mostrar['id']) {
                $info = "selected";
        } else {
                $info = "";
        }
        $cadena = $cadena . '<option value="' . $mostrar['id'] . '" ' . $info . '>' . $mostrar['descripcion'] . '</option>';
}
echo $cadena;
