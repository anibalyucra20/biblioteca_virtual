<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login<?php include ("../../include/header_title.php"); ?></title>
    <!--icono en el titulo-->
    <link rel="shortcut icon" href="../../img/favicon.ico">
    <!-- Bootstrap -->
    <link href="../../Gentella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../Gentella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../Gentella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../../Gentella/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../Gentella/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
     

      <div class="login_wrapper">
        <div class="animate form login_form">
          <center><img src="../../img/logo.png" width="150px"></center>
          <section class="login_content">
            <form role="form" action="iniciar_sesion.php" method="POST">
              <h1>Inicio de Sesión</h1>

              <?php
              include "../../include/conexion.php";
              $fecha_hora_inicio = date("Y-m-d h:i:s");
              echo $fecha_hora_inicio;
              ?>
              <h1>DOCENTES</h1>
              <div>
                <input type="text" class="form-control" placeholder="usuario" required="" name="usuario" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Contraseña" required="" name="password" />
              </div>
              <div>
                <button type="submit">Iniciar Sesión</button>
              </div>
              <br>
              <div><a class="" href="reset_password.php">¿Olvidaste tu Contraseña?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <!--<p class="change_link">¿Eres nuevo?
                  <a href="crearcuenta.php" class="to_register"> Crear Cuenta </a>
                </p>-->

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1>I.E.S.T.P. "HUANTA"</h1>
                  <p>Bienvenido a la plataforma de Portafolio Docente, Inicie Sesion para acceder</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        
      </div>
    </div>
  </body>
</html>
