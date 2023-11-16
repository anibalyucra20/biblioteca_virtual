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
function buscar_libroById($conexion, $id){
    $sql = "SELECT * FROM libros WHERE id='$id'";
    return mysqli_query($conexion, $sql);
}
function buscar_libroByLinkPortada($conexion, $link){
    $sql = "SELECT * FROM libros WHERE link_portada = '$link'";
    return 
    mysqli_query($conexion, $sql);
}


//-------------------------LECTURAS------------------------------
function buscar_lecturasByidLibroUsuTipo($conexion, $id_libro, $usuario, $tipo_usu){
    $sql = "SELECT * FROM lecturas WHERE id_libro='$id_libro' AND id_usuario='$usuario' AND tipo_usuario='$tipo_usu'";
    return mysqli_query($conexion, $sql);
}

function buscar_4lecturas_invert($conexion, $id_usuario, $tipo_usuario){
    $sql = "SELECT * FROM lecturas WHERE id_usuario = '$id_usuario' AND tipo_usuario = '$tipo_usuario' ORDER BY id DESC LIMIT 4";
    return mysqli_query($conexion, $sql);
}

//-------------------------FAVORITOS------------------------------
function buscar_favoritosByidLibroUsuTipo($conexion, $id_libro, $usuario, $tipo_usu){
    $sql = "SELECT * FROM libros_favoritos WHERE id_libro='$id_libro' AND id_usuario='$usuario' AND tipo_usuario='$tipo_usu'";
    return mysqli_query($conexion, $sql);
}
function buscar_4ultimos_favoritos($conexion, $id_usuario, $tipo_usuario){
    $sql = "SELECT * FROM libros_favoritos WHERE id_usuario = '$id_usuario' AND tipo_usuario = '$tipo_usuario' ORDER BY id DESC LIMIT 4";
    return mysqli_query($conexion, $sql);
}
function buscar_favoritos($conexion, $id_usuario, $tipo_usuario){
    $sql = "SELECT * FROM libros_favoritos WHERE id_usuario = '$id_usuario' AND tipo_usuario = '$tipo_usuario' ORDER BY id DESC";
    return mysqli_query($conexion, $sql);
}



?>