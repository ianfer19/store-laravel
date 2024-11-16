@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Comprar Productos</h1>
    
    <div class="row">
        @foreach ($productos as $producto)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-primary h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-primary"><strong>{{ $producto->nombre }}</strong></h5>
                    <p class="card-text"><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                    <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                    <p class="card-text"><strong>Cantidad Disponible:</strong> {{ $producto->cantidad_disponible }}</p>
                    
                    <div class="d-flex align-items-center mt-3">
                        <button class="btn btn-outline-secondary btn-sm me-2" onclick="decrementarCantidad({{ $producto->id_producto }})">-</button>
                        <input type="number" id="cantidad_{{ $producto->id_producto }}" 
                               class="form-control text-center" 
                               value="1" min="1" 
                               max="{{ $producto->cantidad_disponible }}" 
                               style="width: 60px;" />
                        <button class="btn btn-outline-secondary btn-sm ms-2" onclick="incrementarCantidad({{ $producto->id_producto }})">+</button>
                    </div>

                    <div class="d-flex mt-3">
                        <button class="btn btn-primary me-2" onclick="agregarAlCarrito({{ $producto->id_producto }}, '{{ $producto->nombre }}', {{ $producto->precio }}, {{ $producto->cantidad_disponible }})">
                            <i class="fas fa-shopping-cart me-2"></i>Agregar al Carrito
                        </button>

                        <!-- Botón de eliminar (solo si el producto está en el carrito) -->
                        <button class="btn btn-danger btn-sm" id="eliminar_{{ $producto->id_producto }}" style="display: none;" onclick="eliminarProducto({{ $producto->id_producto }})">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Botón de carrito -->
<div id="carritoBoton" class="fixed-bottom mb-4 me-4" style="display: none; text-align: right;">
    <button class="btn btn-success rounded-circle p-3" onclick="mostrarCarrito()">
        <i class="fas fa-shopping-cart"></i>
    </button>
</div>

<!-- Modal del carrito -->
<div class="modal fade" id="modalCarrito" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Carrito de Compras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="carritoProductos"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" onclick="vaciarCarrito()">Vaciar Carrito</button>
                <button class="btn btn-primary" onclick="realizarCompra()">Hacer Compra</button>
            </div>
        </div>
    </div>
</div>

<script>
    let carrito = [];

    function decrementarCantidad(idProducto) {
        const inputCantidad = document.getElementById(`cantidad_${idProducto}`);
        const nuevaCantidad = Math.max(1, parseInt(inputCantidad.value) - 1);
        inputCantidad.value = nuevaCantidad;
    }

    function incrementarCantidad(idProducto) {
        const inputCantidad = document.getElementById(`cantidad_${idProducto}`);
        const maxCantidad = parseInt(inputCantidad.max);
        const nuevaCantidad = Math.min(maxCantidad, parseInt(inputCantidad.value) + 1);
        inputCantidad.value = nuevaCantidad;
    }

    function agregarAlCarrito(idProducto, nombre, precio, cantidadDisponible) {
        const cantidad = parseInt(document.getElementById(`cantidad_${idProducto}`).value);
        const index = carrito.findIndex(item => item.idProducto === idProducto);

        if (index >= 0) {
            carrito[index].cantidad += cantidad;
        } else {
            carrito.push({ idProducto, nombre, precio, cantidad, maxCantidad: cantidadDisponible });
        }

        actualizarCarrito();
        document.getElementById('carritoBoton').style.display = 'block';
        document.getElementById(`eliminar_${idProducto}`).style.display = 'inline-block'; // Mostrar el botón de eliminar
    }

    function eliminarProducto(idProducto) {
        carrito = carrito.filter(item => item.idProducto !== idProducto);
        actualizarCarrito();
        document.getElementById(`eliminar_${idProducto}`).style.display = 'none'; // Ocultar el botón de eliminar
    }

    function decrementarCarrito(idProducto) {
        const index = carrito.findIndex(item => item.idProducto === idProducto);
        if (index >= 0 && carrito[index].cantidad > 1) {
            carrito[index].cantidad--;
            actualizarCarrito();
        }
    }

    function incrementarCarrito(idProducto) {
        const index = carrito.findIndex(item => item.idProducto === idProducto);
        const item = carrito[index];
        const maxCantidad = item.maxCantidad || item.cantidad_disponible;  // Asegúrate de que tengas este valor

        if (item.cantidad < maxCantidad) {
            item.cantidad++;
            actualizarCarrito();
        }
    }

    function actualizarCarrito() {
        const carritoProductos = document.getElementById('carritoProductos');
        carritoProductos.innerHTML = '';

        carrito.forEach(item => {
            const subtotal = item.cantidad * item.precio;
            carritoProductos.innerHTML += `
                <tr>
                    <td>${item.nombre}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary" onclick="decrementarCarrito(${item.idProducto})">-</button>
                        ${item.cantidad}
                        <button class="btn btn-sm btn-outline-secondary" onclick="incrementarCarrito(${item.idProducto})">+</button>
                    </td>
                    <td>$${item.precio.toFixed(2)}</td>
                    <td>$${subtotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${item.idProducto})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`;
        });
    }

    function mostrarCarrito() {
        const modalCarrito = new bootstrap.Modal(document.getElementById('modalCarrito'));
        modalCarrito.show();
    }

    function cerrarCarrito() {
        const modalCarrito = new bootstrap.Modal(document.getElementById('modalCarrito'));
        modalCarrito.hide();
    }

    function vaciarCarrito() {
        carrito = [];
        actualizarCarrito();
        document.getElementById('carritoBoton').style.display = 'none';
    }

    function realizarCompra() {
    if (carrito.length === 0) {
        alert('El carrito está vacío.');
        return;
    }

    const total = carrito.reduce((acc, item) => acc + item.cantidad * item.precio, 0);

    // Verificar que el total sea un número válido
    if (isNaN(total) || total <= 0) {
        alert('El total de la compra no es válido.');
        return;
    }

    const data = {
        total,
        productos: carrito.map(item => ({
            idProducto: item.idProducto,
            cantidad: item.cantidad,
            precio: item.precio
        }))
    };

    console.log('Datos enviados al backend:', data);

    fetch('/ventas', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',  // Se utiliza el token CSRF directamente en el encabezado
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        // Obtener el id_venta desde la respuesta
        const idVenta = data.id_venta;

        console.log(idVenta)

        // Recorrer los productos y crear los detalles de venta
        carrito.forEach(producto => {
            fetch('/detalleVenta', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',  // Si es necesario en tu caso
    },
    body: JSON.stringify({
        id_venta: idVenta,
        id_producto: producto.idProducto,
        cantidad: producto.cantidad,
        precio_unitario: producto.precio,
    })
})
.then(response => response.json())
.then(data => {
    console.log('Detalle de venta creado:', data);
})
.catch(error => {
    console.error('Error al crear el detalle de venta:', error);
});

        });
    })
    .catch(error => {
        console.error('Error al crear la venta:', error);
    });
}


</script>
@endsection
