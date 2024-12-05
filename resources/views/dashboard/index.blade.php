@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Dashboard</h1> <!-- Título centrado -->

    <!-- Fila para las gráficas de compras y ventas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h3>Total de Compras por Mes</h3>
            <canvas id="comprasChart" class="border p-3"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Total de Ventas por Mes</h3>
            <canvas id="ventasChart" class="border p-3"></canvas>
        </div>
    </div>

    <!-- Tabla de detalles de ventas -->
    <h3>Detalles de las Compras</h3>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Fecha de Compra</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detallesVentas as $detalle)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($detalle->fecha_venta)->format('d/m/Y') }}</td>
                    <td>{{ $detalle->producto }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>{{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const comprasData = @json($ventasCompras);
    const ventasData = @json($ventasVentas);

    // Extraer datos de compras
    const comprasLabels = comprasData.map(item => `${item.year}-${item.month}`);
    const comprasTotales = comprasData.map(item => item.total_compras);

    // Configurar gráfica de compras
    new Chart(document.getElementById('comprasChart'), {
        type: 'bar',
        data: {
            labels: comprasLabels,
            datasets: [{
                label: 'Total Compras',
                backgroundColor: '#007bff',
                data: comprasTotales
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Mes'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Total Compras ($)'
                    }
                }
            }
        }
    });

    // Extraer datos de ventas
    const ventasLabels = ventasData.map(item => `${item.year}-${item.month}`);
    const ventasTotales = ventasData.map(item => item.total_ventas);

    // Configurar gráfica de ventas
    new Chart(document.getElementById('ventasChart'), {
        type: 'bar',
        data: {
            labels: ventasLabels,
            datasets: [{
                label: 'Total Ventas',
                backgroundColor: '#28a745',
                data: ventasTotales
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Mes'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Total Ventas ($)'
                    }
                }
            }
        }
    });
</script>

@endsection
