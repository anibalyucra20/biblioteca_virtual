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
    $libro = $_POST['data'];
    $link = $_POST['data2'];
    $id_programa_estudio = $_POST['id_programa'];
    $id_semestre = $_POST['id_semestre'];
    $id_unidad_didactica = $_POST['id_unidad_didactica'];

    $b_libro = buscar_libroById($conexion, $libro);
    $rb_libro = mysqli_fetch_array($b_libro);

    $titulo = $rb_libro['titulo'];
    $autor = $rb_libro['autor'];
    $temas_relacionados = $rb_libro['temas_relacionados'];

    $consulta = "INSERT INTO asignacion_libro (titulo, autor, temas_relacionados,id_libro,id_programa_estudio, id_semestre, id_unidad_didactica) VALUES ('$titulo','$autor','$temas_relacionados','$libro','$id_programa_estudio','$id_semestre','$id_unidad_didactica')";
    if (mysqli_query($conexion, $consulta)) {
        echo "<script>
                    window.location= '../ver_asignaciones.php?libro=".$link."';
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
