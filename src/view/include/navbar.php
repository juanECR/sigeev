<?php 
$vistaActual = explode("/", $_GET['views'] ?? '')[0];

switch ($vistaActual) {
    case 'eventos':
    case 'detalleEvento':
    case 'resultadosEventos':
    case 'participantes':
    case 'tareas':
        $evento = 'active';
        break;
    case 'organizadores':
        $organizador = 'active';
        break;
    case 'empleados':
        $empleado = 'active';
        break;
    case 'emailComunicados':
        $comunicado = 'active';
        break;
    case 'usuarios':
        $usuario = 'active';
        break;
    case '': // El caso por defecto es la página de inicio
    default:
        $home = 'active';
        break;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sistema integral de gestion de eventos municipales</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="<?php echo BASE_URL;?>src/view/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo BASE_URL;?>src/view/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL;?>src/view/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo BASE_URL;?>src/view/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo BASE_URL;?>src/view/css/style.css" rel="stylesheet">
        <script>
        const base_url = '<?php echo BASE_URL; ?>';
        const base_url_server = '<?php echo BASE_URL_SERVER; ?>';
        const session_session = '<?php echo $_SESSION['sesion_id']; ?>';
        const token_token = '<?php echo $_SESSION['sesion_token']; ?>';
    </script>
    <?php date_default_timezone_set('America/Lima');  ?>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="<?php echo BASE_URL;?>" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="bi bi-bar-chart"></i> Sigeev</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="<?php echo BASE_URL;?>src/view/img/user.jpg" alt="perfil" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo  $_SESSION['sesion_usuario_nom'];?></h6>
                        <span><?php echo  $_SESSION['sesion_usuario_rol'];?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a id="nav-inicio" href="<?php echo BASE_URL;?>" class="nav-item nav-link <?php echo $home?>"><i class="bi bi-house-fill"></i>  Home</a>
                    <a id="nav-eventos" href="<?php echo BASE_URL;?>eventos" class="nav-item nav-link <?php echo $evento?>"><i class="fas fa-calendar-week"></i> eventos</a>
                    <a id="nav-organizadores" href="<?php echo BASE_URL;?>organizadores" class="nav-item nav-link <?php echo $organizador?>"><i class="fas fa-building"></i> Organizadores</a>
                    <a id="nav-empleados" href="<?php echo BASE_URL;?>empleados" class="nav-item nav-link <?php echo $empleado?>"><i class="fa fa-users me-2"></i>Empleados</a>
                    <a id="nav-emailComunicados" href="<?php echo BASE_URL;?>emailComunicados" class="nav-item nav-link <?php echo $comunicado?>"><i class="fas fa-envelope-open-text"></i> Comunicados</a>
                    <a id="nav-usuarios" href="<?php echo BASE_URL;?>usuarios" class="nav-item nav-link <?php echo $usuario?>"><i class="fas fa-user-lock"></i> Usuarios</a>              
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->
      <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Buscar">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Mensaje</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="<?php echo BASE_URL;?>src/view/img/user.jpg" alt="perfil" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="<?php echo BASE_URL;?>src/view/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="<?php echo BASE_URL;?>src/view/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificación</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="<?php echo BASE_URL;?>src/view/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo  $_SESSION['sesion_usuario_nom'];?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item"><i class="bi bi-person-lines-fill text-primary"></i> My Profile</a>
                            <a href="#" class="dropdown-item"><i class="bi bi-gear-fill text-primary"></i> Settings</a>
                            <a href="#" class="dropdown-item" onclick="cerrar_sesion();"><i class="fas fa-power-off text-primary"></i> Cerrar sesion</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->