<?php
include("../include/conexion.php");
include("../include/conexion_sispa.php");
include("../include/busquedas.php");
include("../include/busquedas_sispa.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Biblioteca - IESTP HUANTA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="../pp/assets/images/favicon.ico">

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
                                        <h5 class="card-title mb-0">Total de Libros</h5>
                                    </div>
                                    <form role="form" action="operaciones/registrar_libro.php" method="POST" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Programa de Estudios :</label>
                                                <select name="id_programa" id="id_programa_m" class="form-control" required>
                                                    <option value=""></option>
                                                    <?php 
                                                    $b_carreras = buscarCarreras($conexion_sispa);
                                                    while ($r_b_carreras = mysqli_fetch_array($b_carreras)) {?>
                                                        <option value="<?php echo $r_b_carreras['id']; ?>"><?php echo $r_b_carreras['nombre']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Semestre :</label>
                                                <select name="id_semestre" id="id_semestre_m" class="form-control" required>
                                                    <option value=""></option>
                                                    <?php 
                                                    $b_semestre= buscarSemestre($conexion_sispa);
                                                    while ($r_b_semestre = mysqli_fetch_array($b_semestre)) {?>
                                                        <option value="<?php echo $r_b_semestre['id']; ?>"><?php echo $r_b_semestre['descripcion']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Unidad Didáctica :</label>
                                                <select name="id_unidad_didactica" id="id_unidad_didactica_m" class="form-control" required>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Título del Libro :</label>
                                                <input type="text" class="form-control" name="titulo" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Autor :</label>
                                                <input type="text" class="form-control" name="autor" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Editorial :</label>
                                                <input type="text" class="form-control" name="editorial" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">Año de Edicion :</label>
                                                <input type="text" class="form-control" name="edicion" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">Tomo :</label>
                                                <input type="text" class="form-control" name="tomo">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Categoria :</label>
                                                <input type="text" class="form-control" name="categoria" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">ISBN :</label>
                                                <input type="text" class="form-control" name="isbn" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Temas Relacionados :</label>
                                                <textarea class="form-control" name="temas_relacionados" id="" cols="30" rows="10" style="resize: none;" required></textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Archivo :</label>
                                                <input type="file" name="archivo" required accept=".pdf" class="form-control">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom02">Portada :</label>
                                                <input type="file" name="portada" required accept="image/*" class="form-control">
                                            </div>
                                        </div>

                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Registrar</button>
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
      var carr = $('#id_programa_m').val();
      var sem = $('#id_semestre_m').val();
      $.ajax({
        type:"POST",
        url:"operaciones/listar_ud.php",
        data: {id_pe: carr, id_sem: sem},
          success:function(r){
            $('#id_unidad_didactica_m').html(r);
          }
      });
    }
    </script>
</body>

</html>