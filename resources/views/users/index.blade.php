<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
</head>
<body>
    <h1>Usuarios</h1>
    
    <a href="{{ url('/users/create') }}">Crear Nuevo Usuario</a>
    
    <ul>
        @foreach ($users as $user)
            <li>
                <a href="{{ url('/users/' . $user->id) }}">{{ $user->name }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
