<?php
$nombre_fichero = "include/conexion_sispa.php";

if (file_exists($nombre_fichero)) {
    echo "<script> window.location.replace('index.php'); </script>";
} else {

    if (isset($_POST['host'])) {
        $host_sispa = $_POST['host'];
    } else {
        $host_sispa = '';
    }
    if (isset($_POST['db'])) {
        $db_sispa = $_POST['db'];
    } else {
        $db_sispa = '';
    }
    if (isset($_POST['usuario'])) {
        $user_db_sispa = $_POST['usuario'];
    } else {
        $user_db_sispa = '';
    }
    if (isset($_POST['password'])) {
        $pass_db_sispa = $_POST['password'];
    } else {
        $pass_db_sispa = '';
    }

    if ($host_sispa != '' && $db_sispa != '') {
        $conexion_sispa = mysqli_connect($host_sispa, $user_db_sispa, $pass_db_sispa, $db_sispa);
        if ($conexion_sispa) {
            $fh = fopen("include/conexion_sispa.php", 'w') or die("Se produjo un error al crear el archivo");
            $texto = '<?php';
            $texto .= '
$host_sispa = "' . $host_sispa . '";
$db_sispa = "' . $db_sispa . '";
$user_db_sispa = "' . $user_db_sispa . '";
$pass_db_sispa = "' . $pass_db_sispa . '";

$conexion_sispa = mysqli_connect($host_sispa,$user_db_sispa,$pass_db_sispa,$db_sispa);

if ($conexion_sispa) {
	date_default_timezone_set("America/Lima"); 
}else{
	echo "error de conexion a la base de datos";
	
}
$conexion_sispa->set_charset("utf8");
';
            $texto .= '?>';
            fwrite($fh, $texto) or die("No se pudo escribir en el archivo");
            fclose($fh);
            echo "<script>
			alert('Conexión Exitosa');
			window.location.replace('index.php');
		</script>
		";
        } else {
            echo "<script>
			alert('Error de Conexión a la Base de datos, Intenta Nuevamente');
			window.history.back();
		</script>
		";
        }
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inicio - Sispa</title>

        <link href="pp/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="pp/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="pp/assets/css/theme.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body class="login">

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center min-vh-100">
                        <div class="w-100 d-block bg-white shadow-lg rounded my-5">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">

                                        <h1 class="h5 mb-1">BIBLIOTECA VIRTUAL</h1>
                                        <p class="text-muted mb-4">Formulario de Vinculación con sistema SISPA</p>
                                        <form role="form" action="" method="POST">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="host" required="required" placeholder="Servidor (Host)" value="<?php echo $host; ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="db" required="required" placeholder="Nombre de Base de Datos" value="<?php echo $db; ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="usuario" placeholder="Usuario (Base de Datos)" value="<?php echo $usuario; ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="password" placeholder="Contraseña (Base de Datos)" value="<?php echo $password; ?>">
                                            </div>
                                            <center><button type="submit" class="btn btn-primary">Verificar Conexión y Guardar</button></center>
                                        </form>


                                        <!-- end row -->
                                    </div> <!-- end .padding-5 -->
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div> <!-- end .w-100 -->
                    </div> <!-- end .d-flex -->
                </div> <!-- end col-->
            </div> <!-- end row -->
        </div>
        <!-- end container -->
    </body>

    </html>

<?php
}



?>