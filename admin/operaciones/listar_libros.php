<?php
include("../../include/conexion.php");
include("../../include/conexion_sispa.php");
include("../../include/busquedas.php");
include("../../include/busquedas_sispa.php");

$id_ud = $_POST['id_ud'];
$id_pe = $_POST['id_pe'];
$id_sem = $_POST['id_sem'];
$palabra = $_POST['palabra'];

$ejec_cons = buscar_libroByTemaRelacionado($conexion, $palabra);
$contar_r = mysqli_num_rows($ejec_cons);
$cadena = '';
if ($contar_r > 0) {
    $contar = 0;
    while ($mostrar = mysqli_fetch_array($ejec_cons)) {
        $id_libro = $mostrar['id'];
        $b_asignacion = buscar_asignacionByIdLibroAndUd($conexion, $id_libro, $id_ud);
        $cont = mysqli_num_rows($b_asignacion);
        if ($cont == 0) {
            $b_carreras = buscarCarrerasById($conexion_sispa, $mostrar['id_programa_estudio']);
            $r_b_carreras = mysqli_fetch_array($b_carreras);

            $b_semestre = buscarSemestreById($conexion_sispa, $mostrar['id_semestre']);
            $r_b_semestre = mysqli_fetch_array($b_semestre);

            $b_ud = buscarUdById($conexion_sispa, $mostrar['id_unidad_didactica']);
            $r_b_ud = mysqli_fetch_array($b_ud);
            $contar++;
            $cadena = $cadena . '
            <tr><td>' . $contar . '</td>
                <td>' . $mostrar['titulo'] . '</td>
                <td>' . $r_b_carreras['nombre'] . '</td>
                <td>' . $r_b_semestre['descripcion'] . '</td>
                <td>' . $r_b_ud['descripcion'] . '</td>
                <td><button type="button" class="btn btn-success" onclick="agregar_asignacion('.$id_pe.','.$id_sem.','.$id_ud.','.$id_libro.');"><i class="fa fa-plus"></i></button></td>
            </tr>';
        }
    }
}else {
    $cadena.= "no se encontraron resultados";
}

echo $cadena;
