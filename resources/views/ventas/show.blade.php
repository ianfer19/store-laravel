@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles de la Venta</h2>
    
    <div class="mb-3">
        <strong>ID Venta:</strong> {{ $venta->id }}
    </div>
    <div class="mb-3">
        <strong>Usuario:</strong> {{ $venta->usuario->name }}
    </div>
    <div class="mb-3">
        <strong>Total:</strong> ${{ number_format($venta->total, 2) }}
    </div>
    <div class="mb-3">
        <strong>Fecha de Venta:</strong> {{ $venta->fecha_venta }}
    </div>
    
    <h3>Detalles de los Productos</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre Producto</th>
                <th>Cantidad</th>
                <th>Vendedor</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->id_producto }}</td>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->producto->vendedor-> name }}</td>
                    <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>${{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
