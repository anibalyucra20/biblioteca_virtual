<?php
session_start();
include("include/conexion.php");
include("include/conexion_sispa.php");
include("include/busquedas.php");
include("include/busquedas_sispa.php");
include("include/funciones.php");

$sesion_activa = sesion_si_activa($conexion, $_SESSION['id_sesion_biblioteca'], $_SESSION['token_biblioteca']);

if ($sesion_activa) {
    header("location: principal.php");
}else {
    header("location: login/");
}
