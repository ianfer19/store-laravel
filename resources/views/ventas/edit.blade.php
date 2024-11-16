<!-- resources/views/ventas/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Venta</h2>
    <form action="{{ route('ventas.update', $venta->id_venta) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_usuario" class="form-label">Usuario</label>
            <input type="number" class="form-control" id="id_usuario" name="id_usuario" value="{{ $venta->id_usuario }}" required>
        </div>
        <div class="mb-3">
            <label for="id_vendedor" class="form-label">Vendedor</label>
            <input type="number" class="form-control" id="id_vendedor" name="id_vendedor" value="{{ $venta->id_vendedor }}" required>
        </div>
        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" step="0.01" class="form-control" id="total" name="total" value="{{ $venta->total }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Venta</button>
    </form>
</div>
@endsection
