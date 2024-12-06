@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Editar Producto</h1>
    
    <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="imagen">Imagen del producto</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>
        
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required>{{ $producto->descripcion }}</textarea>
        </div>

        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" id="precio" name="precio" class="form-control" value="{{ $producto->precio }}" required>
        </div>

        <div class="form-group">
            <label for="cantidad_disponible">Cantidad Disponible</label>
            <input type="number" id="cantidad_disponible" name="cantidad_disponible" class="form-control" value="{{ $producto->cantidad_disponible }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
    </form>
    
    <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3">Volver a la lista</a>
</div>
@endsection
