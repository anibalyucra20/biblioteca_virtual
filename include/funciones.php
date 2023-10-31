<?php
function generar_llave()
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    function generate_string($input, $strength)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }
    $llave = generate_string($permitted_chars, 20);
    return $llave;
}

function reg_sesion($conexion, $id_usuario, $tipo_acceso, $token)
{
    $fecha_hora_inicio = date("Y-m-d H:i:s");
    $fecha_hora_fin = strtotime('+1 minute', strtotime($fecha_hora_inicio));
    $fecha_hora_fin = date("Y-m-d H:i:s", $fecha_hora_fin);

    $insertar = "INSERT INTO sesiones (id_usuario, tipo_acceso, fecha_hora_inicio, fecha_hora_fin, token) VALUES ('$id_usuario','$tipo_acceso','$fecha_hora_inicio','$fecha_hora_fin','$token')";
    $ejecutar_insertar = mysqli_query($conexion, $insertar);
    if ($ejecutar_insertar) {
        //ultimo registro de sesion
        $id_sesion = mysqli_insert_id($conexion);
        return $id_sesion;
    } else {
        return 0;
    }
}

function sesion_si_activa($conexion, $id_sesion, $token){
    $hora_actuals = date("Y-m-d H:i:s");
    $hora_actual = strtotime('-1 minute', strtotime($hora_actuals));
    $hora_actual = date("Y-m-d H:i:s", $hora_actual);

    $b_sesion = buscar_sesion($conexion, $id_sesion);
    $r_b_sesion = mysqli_fetch_array($b_sesion);

    $fecha_hora_fin_sesion = $r_b_sesion['fecha_hora_fin'];
    $fecha_hora_fin = strtotime('+5 hour', strtotime($fecha_hora_fin_sesion));
    $fecha_hora_fin = date("Y-m-d H:i:s", $fecha_hora_fin);

    if ((password_verify($r_b_sesion['token'], $token)) && ($hora_actual <= $fecha_hora_fin)) {
        actualizar_sesion($conexion, $id_sesion);
        return true;
    } else {
        return false;
    }
}

function actualizar_sesion($conexion, $id_sesion)
{
    $hora_actual = date("Y-m-d H:i:s");
    $nueva_fecha_hora_fin = strtotime('+1 minute', strtotime($hora_actual));
    $nueva_fecha_hora_fin = date("Y-m-d H:i:s", $nueva_fecha_hora_fin);

    $actualizar = "UPDATE sesiones SET fecha_hora_fin='$nueva_fecha_hora_fin' WHERE id=$id_sesion";
    mysqli_query($conexion, $actualizar);
}


function buscar_rol_sesion($conexion,$conexion_sispa, $id_sesion, $token)
{
    $b_sesion = buscar_sesion($conexion, $id_sesion);
    $r_b_sesion = mysqli_fetch_array($b_sesion);
    if (password_verify($r_b_sesion['token'], $token)) {
        $b_docente = buscarDocenteById($conexion_sispa, $r_b_sesion['id_usuario']);
        $cont_docente = mysqli_num_rows($b_docente);
        if ($cont_docente>0) {
            return 1;
        }else {
            $b_estudiante = buscarEstudianteById($conexion_sispa,$r_b_sesion['id_usuario']);
            $cont_estudiante = mysqli_num_rows($b_estudiante);
            if ($cont_estudiante > 0) {
                return 1;
            }else {
                return 0;
            }
        }
        
    }
    return 0;
}



?>