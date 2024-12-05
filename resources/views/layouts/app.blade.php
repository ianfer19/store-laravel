<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahagún de segunda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Para íconos de FontAwesome -->
    <!-- Agregar Font Awesome para los íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column" style="min-height: 100vh;">

<!-- Barra de navegación fija -->
<nav class="navbar navbar-expand-lg navbar-light bg-primary fixed-top">
    <div class="container-fluid">
        <!-- Parte Izquierda: Saludo al usuario -->
        <span class="navbar-text text-white">
            Hola {{ Auth::user()->name }} <!-- Aquí se renderiza el nombre del usuario -->
        </span>

        <!-- Botón para colapsar el menú en pantallas pequeñas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Barra de navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Barra de búsqueda en el centro -->
            <form class="d-flex mx-auto" action="/buscar" method="GET">
                <input class="form-control me-2" type="search" placeholder="Buscar productos..." aria-label="Search" name="query">
                <button class="btn btn-outline-light" type="submit">Buscar</button>
            </form>

            <!-- Parte Derecha: Enlaces y Logout -->
            <div class="d-flex align-items-center">
                <!-- Enlace Inicio con ícono -->
                <a class="nav-link text-white ms-3" href="/productos/comprar">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <!-- Enlace Dashboard con ícono -->
                <a class="nav-link text-white ms-3" href="/dashboard">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <!-- Enlace Mis Compras con ícono -->
                <a class="nav-link text-white ms-3" href="/ventas">
                    <i class="fas fa-shopping-cart"></i> Mis Compras
                </a>
                <!-- Enlace Mis Productos con ícono -->
                <a class="nav-link text-white ms-3" href="/productos/mis-productos">
                    <i class="fas fa-box"></i> Mis Productos
                </a>
                <!-- Enlace Mensajes con ícono -->
                <a class="nav-link text-white ms-3" href="/mensajes">
                    <i class="fas fa-comment-dots"></i> Mensajes
                </a>
                <!-- Enlace Perfil con ícono -->
                <a class="nav-link text-white ms-3" href="/profile/edit">
                    <i class="fas fa-user"></i> Perfil
                </a>
                <!-- Separador -->
                <div class="vr bg-white mx-3" style="width: 2px; height: 25px;"></div>
                <!-- Botón Logout -->
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Contenido de la página -->
<div class="container mt-5 flex-grow-1" style="padding-top:30px">
    @yield('content')
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-auto">
    <div class="container text-center">
        <p>&copy; {{ date('Y') }} Sahagún de Segunda. Todos los derechos reservados.</p>
        <div>
            <!-- Iconos sociales responsivos -->
            <a href="#" class="text-white mx-2"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-white mx-2"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white mx-2"><i class="fab fa-linkedin"></i></a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
