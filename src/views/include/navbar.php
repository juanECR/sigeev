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