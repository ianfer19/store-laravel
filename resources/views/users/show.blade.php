<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Usuario</title>
</head>
<body>
    <h1>Detalles del Usuario</h1>
    
    <p><strong>Nombre:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Teléfono:</strong> {{ $user->telefono }}</p>
    <p><strong>Dirección:</strong> {{ $user->direccion }}</p>
    
    <a href="{{ url('/users/edit/' . $user->id) }}">Editar</a>
</body>
</html>
