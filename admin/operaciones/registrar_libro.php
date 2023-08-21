<?php
include "../../include/conexion.php";
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$editorial = $_POST['editorial'];
$edicion = $_POST['edicion'];
$tomo = $_POST['tomo'];
$categoria = $_POST['categoria'];
$temas_relacionados = $_POST['temas_relacionados'];

$hoy = date("Y-m-d");
$dir_subida = '../../libros/';
$nombre_archivo = $hoy . "_" . $titulo . "_" . $autor . "_" . basename($_FILES['archivo']['name']);
$fichero_subido = $dir_subida . $nombre_archivo;

$dir_subida_portada = '../../img_libro/';
$nombre_portada = $hoy . "_" . $titulo . "_" . $autor .  "_" . basename($_FILES['portada']['name']);
$portada_subido = $dir_subida_portada . $nombre_portada;

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
    $cant_paginas =  contar_paginas("../../libros/ads.pdf");

    $consulta = "INSERT INTO libros (titulo, autor, editorial, edicion, tomo, categoria, temas_relacionados, paginas, ruta_libro, ruta_portada) VALUES ('$titulo', '$autor', '$editorial', '$edicion', '$tomo', '$categoria', '$temas_relacionados', '$cant_paginas', '$nombre_archivo', '$nombre_portada')";
    if (mysqli_query($conexion, $consulta)) {
        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
            if (move_uploaded_file($_FILES['portada']['tmp_name'], $portada_subido)) {
                echo "<script>
			        alert('Se realizó el registro con Éxito');
			        window.location= '../registro_libro.php';
		            </script>
		            ";
            } else {
                echo "<script>
                alert('Error, la portada no se pudo cargar');
                window.history.back();
            </script>
            ";
            }
        } else {
            echo "<script>
			alert('Error, El libro no se pudo cargar');
			window.history.back();
		</script>
		";
        }
    } else {
        echo "<script>
        alert('Error, No se pudo realizar el registro');
        window.history.back();
    </script>
    ";
    }

