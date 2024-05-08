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
    $id_sesion = $_SESSION['id_sesion_biblioteca'];

    $id_libro = $_POST['data'];
    $id_semestre = $_POST['id_semestre'];
    $id_unidad_didactica = $_POST['id_unidad_didactica'];

    $consulta = "UPDATE libros SET id_semestre='$id_semestre',id_unidad_didactica='$id_unidad_didactica',id_sesion='$id_sesion' WHERE id='$id_libro'";
    if (mysqli_query($conexion, $consulta)) {
        echo "<script>
			        alert('Actualizado Correctamente');
                    window.location= '../reasignar_libro.php';
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


