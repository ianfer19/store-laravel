<!-- resources/views/ventas/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Ventas</h2>
    <a href="{{ route('dashboard') }}" class="btn btn-primary mb-3">Ir a comprar</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->id_venta }}</td>
                    <td>{{ $venta->usuario->name }}</td>
                    <td>${{ number_format($venta->total, 2) }}</td>
                    <td>{{ $venta->fecha_venta }}</td>
                    <td>
                        <a href="{{ route('ventas.show', $venta->id_venta) }}" class="btn btn-info btn-sm">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
