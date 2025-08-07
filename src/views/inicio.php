<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Futurista - Menú Superior</title>
    <link rel="stylesheet" href="css/inicio.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <header class="top-navbar">
        <div class="navbar-left">
            <a href="#" class="logo">
                <span class="material-symbols-outlined">public</span>
                <span class="logo-text">DATA-NEXUS</span>
            </a>
            <nav class="nav-links">
                <a href="#" class="nav-item active">Dashboard</a>
                <a href="#" class="nav-item">Analíticas</a>
                <a href="#" class="nav-item">Reportes</a>
                <a href="#" class="nav-item">Integraciones</a>
            </nav>
        </div>
        <div class="navbar-right">
            <button class="icon-button">
                <span class="material-symbols-outlined">search</span>
            </button>
            <button class="icon-button">
                <span class="material-symbols-outlined">notifications</span>
            </button>
            <div class="user-profile">
                <img src="https://via.placeholder.com/40" alt="Foto de perfil">
            </div>
            <!-- Botón de Menú para móvil -->
            <button class="icon-button" id="mobile-menu-toggle">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>

    <main class="main-content">
        <div class="page-header">
            <h1>Resumen General</h1>
            <p>Estado del sistema en tiempo real.</p>
        </div>

        <div class="dashboard-grid">
            <!-- Las tarjetas usan el nuevo estilo futurista -->
            <div class="card">
                <div class="card-header">
                    <h3>Ingresos Totales</h3>
                    <span class="material-symbols-outlined">monitoring</span>
                </div>
                <div class="card-body">
                    <h2>$1,283,491.52</h2>
                    <p class="positive">+12.5% vs Q2</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Carga del Servidor</h3>
                    <span class="material-symbols-outlined">dns</span>
                </div>
                <div class="card-body">
                    <h2>78%</h2>
                    <p class="negative">Alto - Se requiere monitoreo</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Nuevos Usuarios (Mes)</h3>
                    <span class="material-symbols-outlined">group_add</span>
                </div>
                <div class="card-body">
                    <h2>+1,830</h2>
                    <p class="positive">Objetivo superado</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Tickets de Soporte</h3>
                    <span class="material-symbols-outlined">support_agent</span>
                </div>
                <div class="card-body">
                    <h2>42</h2>
                    <p class="neutral">8 Resueltos hoy</p>
                </div>
            </div>
        </div>
        <!-- Puedes añadir más contenido aquí para probar el scroll -->
    </main>

    <script src="script.js"></script>
</body>
</html>
