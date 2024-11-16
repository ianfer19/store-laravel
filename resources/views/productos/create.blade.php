<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
</head>
<body>
    <h1>Crear Producto</h1>
    
    <form action="{{ route('productos.store') }}" method="POST">
        @csrf
        
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        
        <label for="precio">Precio</label>
        <input type="number" id="precio" name="precio" required>
        
        <label for="cantidad_disponible">Cantidad Disponible</label>
        <input type="number" id="cantidad_disponible" name="cantidad_disponible" required>
        
        <label for="id_vendedor">ID del Vendedor</label>
        <input type="text" id="id_vendedor" name="id_vendedor" required>
        
        <button type="submit">Crear Producto</button>
    </form>
    
    <a href="{{ route('productos.index') }}">Volver a la lista</a>
</body>
</html>
