<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
</head>
<body>
    <h1>Detalles del Producto</h1>
    
    <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
    <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
    <p><strong>Precio:</strong> {{ $producto->precio }}</p>
    <p><strong>Cantidad Disponible:</strong> {{ $producto->cantidad_disponible }}</p>
    <p><strong>ID del Vendedor:</strong> {{ $producto->id_vendedor }}</p>
    
    <a href="{{ route('productos.index') }}">Volver a la lista</a>
</body>
</html>
@extends('layouts.app')