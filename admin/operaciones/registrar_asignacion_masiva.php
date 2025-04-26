<?php
include("../../include/conexion.php");
include("../../include/conexion_sispa.php");
include("../../include/busquedas.php");
include("../../include/busquedas_sispa.php");
include("../../include/funciones.php");

$id_programa_estudio = $_POST['id_pe'];
$id_semestre = $_POST['id_sem'];
$id_unidad_didactica = $_POST['id_ud'];
$libro = $_POST['libro'];

if ($id_programa_estudio == 0 || $id_semestre == 0 || $id_unidad_didactica == 0 || $libro == 0) {
    echo "<script>
    alert('Error, no se registro');
</script>
";
} else {
    $b_asignacion = buscar_asignacionByIdLibroAndUd($conexion, $libro, $id_unidad_didactica);
    $cont = mysqli_num_rows($b_asignacion);
    if ($cont == 0) {
        $b_libro = buscar_libroById($conexion, $libro);
        $rb_libro = mysqli_fetch_array($b_libro);

        $titulo = $rb_libro['titulo'];
        $autor = $rb_libro['autor'];
        $temas_relacionados = $rb_libro['temas_relacionados'];

        $consulta = "INSERT INTO asignacion_libro (titulo, autor, temas_relacionados,id_libro,id_programa_estudio, id_semestre, id_unidad_didactica) VALUES ('$titulo','$autor','$temas_relacionados','$libro','$id_programa_estudio','$id_semestre','$id_unidad_didactica')";
        if (mysqli_query($conexion, $consulta)) {
            echo "Registro exitoso";
        } else {
            echo "<script>
                alert('Error, no se registro');
            </script>
            ";
        }
    }else {
        echo "<script>
            alert('Error, libro ya asignado a la unidad didactica');
        </script>
        ";
    }
}
