@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Lista de Productos</h1>
    
    <a href="{{ route('productos.create') }}" class="btn btn-success mb-4">Crear Nuevo Producto</a>
    
    <div class="row">
        @foreach ($productos as $producto)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-primary h-100">
                <div class="card-body d-flex flex-column">
                   @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="width: 150px; height: auto;">
                    @else
                        <p>Sin imagen</p>
                    @endif
                    <h5 class="card-title text-primary"><strong>{{ $producto->nombre }}</strong></h5>
                    <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                    <p class="card-text"><strong>Cantidad Disponible:</strong> {{ $producto->cantidad_disponible }}</p>
                    <p class="card-text"><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                    <div class="mt-auto">
                        <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn btn-warning btn-sm me-2">Editar</a>
                        <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
