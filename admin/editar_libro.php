<?php
session_start();
include("../include/conexion.php");
include("../include/conexion_sispa.php");
include("../include/busquedas.php");
include("../include/busquedas_sispa.php");
include("../include/funciones.php");
include("../include/verificar_sesion_admin.php");

if (!verificar_sesion($conexion) == 1) {
    echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('../index.php');
              </script>";
} else {

    $buscar_sesion = buscar_sesion($conexion, $_SESSION['id_sesion_biblioteca']);
    $r_buscar_sesion = mysqli_fetch_array($buscar_sesion);
    $id_usuario = $r_buscar_sesion['id_usuario'];

    if ($r_buscar_sesion['tipo_acceso'] == 'docente') {
        $b_usuario = buscarDocenteById($conexion_sispa, $r_buscar_sesion['id_usuario']);
        $tipo_usuario = "docente";
    }else {
        echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('../index.php');
              </script>";
    }
    $r_b_usuario = mysqli_fetch_array($b_usuario);

    $libro = $_GET['libro'];
    $b_libro = buscar_libroByLinkPortada($conexion, $libro);
    $r_b_libro = mysqli_fetch_array($b_libro);
    $id_libro = $r_b_libro['id'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Biblioteca - IESTP HUANTA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="../images/favicon.ico">

    <!-- App css -->
    <link href="../plugins/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="../pp/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../pp/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../pp/assets/css/theme.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        <div class="main-content">
            <?php include "include/menu.php"; ?>
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0">Editar datos de libro</h5>
                                    </div>
                                    <form role="form" action="operaciones/actualizar_libro.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="data" id="libro_m" value="<?php echo $r_b_libro['id']; ?>">    
                                    <input type="hidden" name="ud" id="id_ud_m" value="<?php echo $r_b_libro['id_unidad_didactica']; ?>">    
                                    <input type="hidden" name="paginas" value="<?php echo $r_b_libro['paginas']; ?>">    
                                    <input type="hidden" name="link_portada" value="<?php echo $r_b_libro['link_portada']; ?>">    
                                    <input type="hidden" name="link_libro" value="<?php echo $r_b_libro['link_libro']; ?>">    
                                    <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Programa de Estudios :</label>
                                                <select name="id_programa" id="id_programa_m" class="form-control" required value="<?php echo $r_b_libro['id_programa_estudio']; ?>">
                                                    <option value=""></option>
                                                    <?php 
                                                    $b_carreras = buscarCarreras($conexion_sispa);
                                                    while ($r_b_carreras = mysqli_fetch_array($b_carreras)) {?>
                                                        <option value="<?php echo $r_b_carreras['id']; ?>" <?php if($r_b_carreras['id']==$r_b_libro['id_programa_estudio']){echo "selected";} ?>><?php echo $r_b_carreras['nombre']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Semestre :</label>
                                                <select name="id_semestre" id="id_semestre_m" class="form-control" required value="<?php echo $r_b_libro['id_semestre']; ?>">
                                                    <option value=""></option>
                                                    <?php 
                                                    $b_semestre= buscarSemestre($conexion_sispa);
                                                    while ($r_b_semestre = mysqli_fetch_array($b_semestre)) {?>
                                                        <option value="<?php echo $r_b_semestre['id']; ?>" <?php if($r_b_semestre['id']==$r_b_libro['id_semestre']){echo "selected";} ?>><?php echo $r_b_semestre['descripcion']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Unidad Didáctica :</label>
                                                <select name="id_unidad_didactica" id="id_unidad_didactica_m" class="form-control" required value="<?php echo $r_b_libro['id_unidad_didactica']; ?>">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Título del Libro :</label>
                                                <input type="text" class="form-control" name="titulo" required value="<?php echo $r_b_libro['titulo']; ?>">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Autor :</label>
                                                <input type="text" class="form-control" name="autor" required value="<?php echo $r_b_libro['autor']; ?>">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Editorial :</label>
                                                <input type="text" class="form-control" name="editorial" required value="<?php echo $r_b_libro['editorial']; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">Año de Edicion :</label>
                                                <input type="text" class="form-control" name="edicion" value="<?php echo $r_b_libro['edicion']; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">Tomo :</label>
                                                <input type="text" class="form-control" name="tomo" value="<?php echo $r_b_libro['tomo']; ?>">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Categoria :</label>
                                                <input type="text" class="form-control" name="categoria" required value="<?php echo $r_b_libro['tipo_libro']; ?>">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">ISBN :</label>
                                                <input type="text" class="form-control" name="isbn" value="<?php echo $r_b_libro['isbn']; ?>">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Temas Relacionados :</label>
                                                <textarea class="form-control" name="temas_relacionados" id="" cols="30" rows="10" style="resize: none;" required><?php echo $r_b_libro['temas_relacionados']; ?></textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Archivo :</label>
                                                <input type="file" name="archivo" accept=".pdf" class="form-control">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Portada :</label>
                                                <input type="file" name="portada" accept="image/*" class="form-control">
                                            </div>
                                        </div>

                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Actualizar</button>
                                    </form>
                                </div>
                                <!--end card body-->
                            </div><!-- end card-->
                        </div> <!-- end col-->

                    </div>
                    <!-- end page title -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include "../include/footer.php"; ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- jQuery  -->
    <script src="../pp/assets/js/jquery.min.js"></script>
    <script src="../pp/assets/js/bootstrap.bundle.min.js"></script>
    <script src="../pp/assets/js/waves.js"></script>
    <script src="../pp/assets/js/simplebar.min.js"></script>

    <script src="../pp/assets/pages/validation-demo.js"></script>

    <script src="../plugins/dropify/dropify.min.js"></script>

    <!-- Init js-->
    <script src="../pp/assets/pages/fileuploads-demo.js"></script>
    <!-- App js -->
    <script src="../pp/assets/js/theme.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        listar_uds();
        $('#id_programa_m').change(function(){
          listar_uds();
        });
        $('#id_semestre_m').change(function(){
          listar_uds();
        });
        
      })
    </script>                                                     
    <script type="text/javascript">
     function listar_uds(){
      var ud = $('#id_ud_m').val();
      var carr = $('#id_programa_m').val();
      var sem = $('#id_semestre_m').val();
      $.ajax({
        type:"POST",
        url:"operaciones/listar_ud_edit.php",
        data: {id_pe: carr, id_sem: sem, id_ud: ud},
          success:function(r){
            $('#id_unidad_didactica_m').html(r);
          }
      });
    }
    </script>
</body>

</html>
<?php }