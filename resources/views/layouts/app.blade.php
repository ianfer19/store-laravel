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
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid">
        <!-- Parte Izquierda: Saludo al usuario -->
        <span class="navbar-text text-white">
            Hola {{ Auth::user()->name }} <!-- Aquí se renderiza el nombre del usuario -->
        </span>

        <!-- Barra de búsqueda en el centro -->
        <form class="d-flex mx-auto" action="/buscar" method="GET">
            <input class="form-control me-2" type="search" placeholder="Buscar productos..." aria-label="Search" name="query">
            <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>

        <!-- Parte Derecha: Enlaces y Logout -->
        <div class="d-flex align-items-center">
            <!-- Enlace Inicio con ícono -->
            <a class="nav-link text-white ms-3" href="/dashboard">
                <i class="fas fa-home"></i> Inicio
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
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
        </div>
    </div>
</nav>



    <!-- Contenido de la página -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
