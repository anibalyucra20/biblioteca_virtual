<?php
include("../include/conexion.php");
include("../include/conexion_sispa.php");
include("../include/busquedas.php");
include("../include/busquedas_sispa.php");
include("../include/funciones.php");
$usuario = $_POST['usuario'];
$pass = $_POST['password'];

//buscar docente
$b_docente = buscarDocenteByDni($conexion_sispa, $usuario);
$cont_docente =mysqli_num_rows($b_docente);
$r_b_docente = mysqli_fetch_array($b_docente);

//buscar estudiante
$b_estudiante = buscarEstudianteByDni($conexion_sispa,$usuario);
$cont_estudiante = mysqli_num_rows($b_estudiante);
$r_b_estudiante = mysqli_fetch_array($b_estudiante);


if ($cont_docente>0 ) {
	if (password_verify($pass, $r_b_docente['password'])) {
		$id_docente = $r_b_docente['id'];
	$cargo_docente = $r_b_docente['id_cargo'];
	if ($r_b_docente['activo'] != 1) {
		echo "<script>
                alert('Error, Usted no se encuentra activo en el sistema, Por Favor Contacte con el Administrador');
                window.location.replace('../login/');
    		</script>";
	}else {
		session_start();
		$llave = generar_llave();
		if ($cargo_docente != 0) {
			$id_sesion = reg_sesion($conexion, $id_docente,'docente', $llave);
			if ($id_sesion != 0) {
				$token = password_hash($llave, PASSWORD_DEFAULT);
				$_SESSION['id_sesion_biblioteca'] = $id_sesion;
				$_SESSION['token_biblioteca'] = $token;
				echo "<script> window.location.replace('../index.php'); </script>";
			} else {
				echo "<script>
                alert('Error al Iniciar Sesión. Intente Nuevamente');
				window.location.replace('../login/');
    		</script>";
			}
		} else {
			echo "<script>
                alert('Error en cargo, contacte administrador');
				window.location.replace('../login/');
    		</script>";
		}
	}
	}else {
		echo "<script>
                alert('Contraseña incorrecta');
				window.location.replace('../login/');
    		</script>";
	}
	
}elseif($cont_estudiante>0) {
	if (password_verify($pass, $r_b_estudiante['password'])) {
		$id_estudiante = $r_b_estudiante['id'];
	if ($r_b_estudiante['activo'] != 1) {
		echo "<script>
                alert('Error, Usted no se encuentra activo en el sistema, Por Favor Contacte con el Administrador');
                window.location.replace('../login/');
    		</script>";
	}else {
		session_start();
		$llave = generar_llave();
		$id_sesion = reg_sesion($conexion, $id_estudiante,'estudiante', $llave);
			if ($id_sesion != 0) {
				$token = password_hash($llave, PASSWORD_DEFAULT);
				$_SESSION['id_sesion_biblioteca'] = $id_sesion;
				$_SESSION['token_biblioteca'] = $token;
				echo "<script> window.location.replace('../index.php'); </script>";
			} else {
				echo "<script>
                alert('Error al Iniciar Sesión. Intente Nuevamente');
				window.location.replace('../login/');
    		</script>";
			}
	}
	}else {
		echo "<script>
                alert('Contraseña incorrecta');
				window.location.replace('../login/');
    		</script>";
	}
	
}else {
	echo "<script>
                alert('Usuario o Contraseña incorrecto');
				window.location.replace('../login/');
    		</script>";
}
mysqli_close($conexion);
