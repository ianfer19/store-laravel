<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Mostrar todos los productos
    public function index()
    {
        $productos = Producto::all(); // Obtener todos los productos de la base de datos
        return view('productos.index', compact('productos')); // Enviar los productos a la vista
    }

        // Mostrar todos los productos
        public function comprar()
        {
            $productos = Producto::all(); // Obtener todos los productos de la base de datos
            return view('productos.comprar', compact('productos')); // Enviar los productos a la vista
        }

        /**
     * Mostrar un usuario específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return view('productos.show', compact('producto')); 
    }

    // Mostrar el formulario para crear un nuevo producto
    public function create()
    {
        return view('productos.create'); // Mostrar el formulario de creación
    }

    // Crear un nuevo producto
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad_disponible' => 'required|integer',
            'id_vendedor' => 'required|string',
        ]);

        // Crear el producto en la base de datos
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad_disponible' => $request->cantidad_disponible,
            'id_vendedor' => $request->id_vendedor,
        ]);

        // Redirigir a la lista de productos
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    // Mostrar el formulario para editar un producto
    public function edit($id)
    {
        $producto = Producto::findOrFail($id); // Obtener el producto por su ID
        return view('productos.edit', compact('producto')); // Enviar el producto a la vista de edición
    }

    // Actualizar un producto
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad_disponible' => 'required|integer',
            'id_vendedor' => 'required|string',
        ]);

        // Obtener el producto por su ID
        $producto = Producto::findOrFail($id);

        // Actualizar los datos del producto
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad_disponible' => $request->cantidad_disponible,
            'id_vendedor' => $request->id_vendedor,
        ]);

        // Redirigir a la lista de productos
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    // Eliminar un producto
    public function destroy($id)
    {
        // Eliminar el producto de la base de datos
        Producto::destroy($id);

        // Redirigir a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente');
    }
}
