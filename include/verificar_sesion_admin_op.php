<?php
function verificar_sesion($conexion){
	session_start();
	if (isset($_SESSION['id_sesion_biblioteca'])) {
		$sesion_activa = sesion_si_activa($conexion, $_SESSION['id_sesion_biblioteca'], $_SESSION['token_biblioteca']);
		if (!$sesion_activa) {
			echo "<script>
                alert('La Sesion Caducó, Inicie Sesión');
                window.location.replace('../../include/cerrar_sesion.php');
    		</script>";
		}else {
				return 1;
		}
	}else {
		return 0;
	}
}

?>