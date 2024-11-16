<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
    
    <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST">
        @csrf
        @method('PUT')
        
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="{{ $producto->nombre }}" required>
        
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" required>{{ $producto->descripcion }}</textarea>
        
        <label for="precio">Precio</label>
        <input type="number" id="precio" name="precio" value="{{ $producto->precio }}" required>
        
        <label for="cantidad_disponible">Cantidad Disponible</label>
        <input type="number" id="cantidad_disponible" name="cantidad_disponible" value="{{ $producto->cantidad_disponible }}" required>
        
        <label for="id_vendedor">ID del Vendedor</label>
        <input type="text" id="id_vendedor" name="id_vendedor" value="{{ $producto->id_vendedor }}" required>
        
        <button type="submit">Actualizar Producto</button>
    </form>
    
    <a href="{{ route('productos.index') }}">Volver a la lista</a>
</body>
</html>
