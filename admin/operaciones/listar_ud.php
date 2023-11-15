<?php
include("../../include/conexion.php");
include("../../include/conexion_sispa.php");
include("../../include/busquedas.php");
include("../../include/busquedas_sispa.php");

$id_pe = $_POST['id_pe'];
$id_sem = $_POST['id_sem'];

$ejec_cons = buscarUdByCarSem($conexion_sispa, $id_pe, $id_sem);

$cadena = '<option></option>';

while ($mostrar = mysqli_fetch_array($ejec_cons)) {
    
        $cadena = $cadena . '<option value="'.$mostrar['id'].'">'.$mostrar['descripcion'].'</option>';
    
}
echo $cadena;
