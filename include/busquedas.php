<?php
function buscar_sesion($conexion, $id_sesion){
    $sql = "SELECT * FROM sesiones WHERE id='$id_sesion'";
	return mysqli_query($conexion, $sql);
}



//-------------------------LIBROS------------------------------
function buscar_libro($conexion){
    $sql = "SELECT * FROM libros";
    return mysqli_query($conexion, $sql);
}




?>