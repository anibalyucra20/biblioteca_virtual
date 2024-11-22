<?php
session_start();
include("../../include/conexion.php");
include("../../include/conexion_sispa.php");
include("../../include/busquedas.php");
include("../../include/busquedas_sispa.php");
include("../../include/funciones.php");
include("../../include/verificar_sesion_admin_op.php");

if (!verificar_sesion($conexion) == 1) {
    echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('../../index.php');
              </script>";
} else {

    $link = $_GET['data'];
    $id_asignacion = $_GET['data2'];

    $consulta = "DELETE FROM asignacion_libro WHERE id='$id_asignacion'";
    if (mysqli_query($conexion, $consulta)) {
        echo "<script>
        window.location= '../ver_asignaciones.php?libro=" . $link . "';
        </script>
        ";
    } else {
        echo "<script>
        alert('Error, No se pudo realizar el registro');
        window.history.back();
    </script>
    ";
    }
}
