<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad_disponible' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:4048',
        ]);
    
        // Manejo de la imagen
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('imagenes_productos', 'public');
        }
    
        // Crear producto
        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad_disponible' => $request->cantidad_disponible,
            'imagen' => $imagenPath,
            'id_vendedor' => Auth::id(),
        ]);
    
        return redirect()->route('productos.mis_productos')->with('success', 'Producto creado exitosamente');
    }
    

        // Obtener todos los productos de un usuario específico
        public function misProductos()
        {
            $userId = Auth::id(); // Obtener el ID del usuario autenticado
            $productos = Producto::where('id_vendedor', $userId)->get(); // Productos del usuario
        
            return view('productos.mis_productos', compact('productos'));
        }
        


    // Mostrar el formulario para editar un producto
    public function edit($id)
    {
        $producto = Producto::findOrFail($id); // Obtener el producto por su ID
        return view('productos.edit', compact('producto')); // Enviar el producto a la vista de edición
    }

    public function update(Request $request, $id_producto)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad_disponible' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:4048', // Validación de la imagen
        ]);
    
        // Obtener el producto por su ID
        $producto = Producto::findOrFail($id_producto);
    
        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            // Si hay una nueva imagen, eliminar la antigua
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            
            // Subir la nueva imagen
            $imagenPath = $request->file('imagen')->store('imagenes_productos', 'public');
        } else {
            // Mantener la imagen antigua si no se sube una nueva
            $imagenPath = $producto->imagen;
        }
    
        // Actualizar el producto
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad_disponible' => $request->cantidad_disponible,
            'imagen' => $imagenPath,  // Guardar la imagen (nueva o antigua)
        ]);
    
        return redirect()->route('productos.mis_productos')->with('success', 'Producto actualizado exitosamente');
    }
    
    

    // Eliminar un producto
    public function destroy($id)
    {
        // Eliminar el producto de la base de datos
        Producto::destroy($id);

        // Redirigir a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.mis_productos')->with('success', 'Producto eliminado exitosamente');
    }
}
