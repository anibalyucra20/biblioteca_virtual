<?php
session_start();
include("../../include/conexion.php");
include("../../include/conexion_sispa.php");
include("../../include/busquedas.php");
include("../../include/busquedas_sispa.php");
include("../../include/funciones.php");
//include("../../include/verificar_sesion_admin_op.php");

/*if (!verificar_sesion($conexion) == 1) {
    echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('../../index.php');
              </script>";
} else {
*/
    $id_sesion = $_SESSION['id_sesion_biblioteca'];

    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];
    $edicion = $_POST['edicion'];
    $tomo = $_POST['tomo'];
    $categoria = $_POST['categoria'];
    $isbn = $_POST['isbn'];
    $temas_relacionados = $_POST['temas_relacionados'];
    $id_programa_estudio = $_POST['id_programa'];
    $id_semestre = $_POST['id_semestre'];
    $id_unidad_didactica = $_POST['id_unidad_didactica'];


    $hoy = date("Y-m-d H:i:s");
    $nombre_archivos = $hoy . "_" . $titulo . "_" . $autor;
    // cargar archivos a google
    include '../../librerias/google-api/vendor/autoload.php';
    putenv('GOOGLE_APPLICATION_CREDENTIALS=../../librerias/credencial.json'); // cargamos la ruta de la credencial

    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->setScopes(['https://www.googleapis.com/auth/drive.file']);

    try {
        $service = new Google_Service_Drive($client);
        $file_path_portada = $_FILES['portada']['tmp_name'];
        $file_path_libro = $_FILES['archivo']['tmp_name'];

        $file_portada = new Google_Service_Drive_DriveFile();
        $file_libro = new Google_Service_Drive_DriveFile();

        $file_portada->setName($nombre_archivos); //el nombre con el que cargaremos
        $file_libro->setName($nombre_archivos); //el nombre con el que cargaremos

        $finfo_portada = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type_portada = finfo_file($finfo_portada, $file_path_portada);

        $finfo_libro = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type_libro = finfo_file($finfo_libro, $file_path_libro);

        $file_portada->setParents(array("1IoNbSLR7kIp18_PDMOH-ALrkhj6A-Afg")); // id de la carpeta a la que subiremos el archivo
        $file_libro->setParents(array("1BqvnFYfogaWBMEzXy9KDGwXLaPnt1ecf")); // id de la carpeta a la que subiremos el archivo

        $file_portada->setDescription(""); // descripcion del archivo subido
        $file_libro->setDescription(""); // descripcion del archivo subido

        $file_portada->setMimeType($mime_type_portada); // tipo de aarchivo
        $file_libro->setMimeType($mime_type_libro); // tipo de aarchivo

        $resultado_portada = $service->files->create(
            $file_portada,
            array(
                'data' => file_get_contents($file_path_portada),
                'mimeType' => $mime_type_portada,
                'uploadType' => 'media'
            )
        );
        $resultado_libro = $service->files->create(
            $file_libro,
            array(
                'data' => file_get_contents($file_path_libro),
                'mimeType' => $mime_type_libro,
                'uploadType' => 'media'
            )
        );

        $id_portada_drive = $resultado_portada->id;
        $id_libro_drive = $resultado_libro->id;
    } catch (Google_Service_Exception $gs) {
        $mensaje = json_decode($gs->getMessage());
        echo $mensaje->Error->message();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    function contar_paginas($filePath)
    {
        if (!file_exists($filePath))
            return 0;
        if (!$fp = @fopen($filePath, "r"))
            return 0;
        $i = 0;
        $type = "/Contents";
        while (!feof($fp)) {
            $line = fgets($fp, 255);
            $x = explode($type, $line);
            if (count($x) > 1) {
                $i++;
            }
        }
        fclose($fp);
        return (int) $i;
    }
    $cant_paginas =  contar_paginas($_FILES['archivo']['tmp_name']);



    $consulta = "INSERT INTO libros (titulo, autor, editorial, edicion, tomo, tipo_libro, isbn, paginas, temas_relacionados,id_programa_estudio, id_semestre, id_unidad_didactica, link_portada, link_libro, id_sesion) VALUES ('$titulo', '$autor', '$editorial', '$edicion', '$tomo', '$categoria','$isbn', '$cant_paginas', '$temas_relacionados','$id_programa_estudio','$id_semestre','$id_unidad_didactica', '$id_portada_drive', '$id_libro_drive','$id_sesion')";
    if (mysqli_query($conexion, $consulta)) {
        $id_libro = mysqli_insert_id($conexion);
        migrar_libro_asignacion($conexion, $id_libro);
        echo "<script>
			        alert('Se realizó el registro con Éxito');
                    window.location= '../libros.php';
		            </script>
		            ";
    } else {
        echo "<script>
        alert('Error, No se pudo realizar el registro');
        window.history.back();
    </script>
    ";
    }
//}
