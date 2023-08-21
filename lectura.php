<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Lectura - IESTP HUANTA</title>
    <?php include "include/header.php"; ?>
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4>TITULO DEL LIBRO</h4>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <embed src="https://sispa.iestphuanta.edu.pe/ads.pdf" width="100%" height="900" />
                                            <iframe src="https://sispa.iestphuanta.edu.pe/ads.pdf" width="100%" height="900" allow="autoplay"></iframe>
                                            <object class="" data="https://sispa.iestphuanta.edu.pe/ads.pdf" type="application/pdf" width="100%" height="900"></object>
                                            
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- end page title -->


                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include "include/footer.php"; ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include "include/pie_scripts.php"; ?>

</body>

</html>