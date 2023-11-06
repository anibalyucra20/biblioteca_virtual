<header id="page-topbar">
    <div class="navbar-header">
        <!-- LOGO -->
        <div class="navbar-brand-box d-flex align-items-left">
            <a href="index.php" class="logo">
                <img src="images/logo.png" alt="" width="90px">
                <span>
                    Biblioteca Virtual IESTP HUANTA
                </span>
            </a>

            <button type="button" class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex align-items-center">
<!--
            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect waves-light" id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
-->
            </div>
            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn header-item waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="images/no-image.jpeg" alt="Header Avatar">
                    <span class="d-none d-sm-inline-block ml-1"><?php echo $r_b_usuario['apellidos_nombres'];?></span>
                    <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="include/cerrar_sesion.php">
                        <span>Cerrar Sesión</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</header>
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="principal.php">
                            <i class="fas fa-home"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="biblioteca.php">
                            <i class="fas fa-book"></i>Biblioteca
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="favoritos.php">
                            <i class="far fa-bookmark"></i>Mis Favoritos
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>