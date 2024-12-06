@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Mis Productos</h1>
    @if ($productos->isEmpty())
    <div class="mb-3">
            <a href="{{ route('productos.create') }}" class="btn btn-primary">Crear Producto</a>
        </div>

            <p>No tienes productos registrados.</p>

    @else
    <div class="mb-3">
            <a href="{{ route('productos.create') }}" class="btn btn-primary">Crear Producto</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                     <th>Imagen</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad Disponible</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <p>Sin imagen</p>
                            @endif
                        </td>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{ $producto->cantidad_disponible }}</td>
                        <td>
                            <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
