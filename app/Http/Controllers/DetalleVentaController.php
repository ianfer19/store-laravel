<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class DetalleVentaController extends Controller
{
    /**
     * Mostrar todos los detalles de venta.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detallesVenta = DetalleVenta::all();
        return response()->json($detallesVenta);
    }

    /**
     * Crear un nuevo detalle de venta.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

     public function storeDetalleVenta(Request $request)
     {
         // Calcular el subtotal manualmente (si no es una columna generada en MySQL)
         $subtotal = $request->cantidad * $request->precio_unitario;
     
         // Crear el detalle de venta sin el campo 'subtotal' (si la columna es generada)
         try {
             $detalleVenta = DetalleVenta::create([
                 'id_venta' => $request->id_venta,
                 'id_producto' => $request->id_producto,
                 'cantidad' => $request->cantidad,
                 'precio_unitario' => $request->precio_unitario,
                 // No incluir 'subtotal' si es una columna generada
             ]);
     
             return response()->json($detalleVenta, 201); // Responder con el detalle de venta creado
         } catch (\Exception $e) {
             // Log de errores
             Log::error("Error al crear el detalle de venta: " . $e->getMessage()); // Registrar el error completo
             return response()->json(['error' => 'Error al crear el detalle de venta'], 500); // Error 500
         }
     }
     



    /**
     * Mostrar un detalle de venta específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detalleVenta = DetalleVenta::find($id);

        if (!$detalleVenta) {
            return response()->json(['message' => 'Detalle de venta no encontrado'], 404);
        }

        return response()->json($detalleVenta);
    }

    /**
     * Actualizar un detalle de venta.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $detalleVenta = DetalleVenta::find($id);

        if (!$detalleVenta) {
            return response()->json(['message' => 'Detalle de venta no encontrado'], 404);
        }

        // Validación de los datos recibidos
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric',
        ]);

        // Actualizar el detalle de venta
        $detalleVenta->update([
            'cantidad' => $request->cantidad,
            'precio_unitario' => $request->precio_unitario,
            'subtotal' => $request->cantidad * $request->precio_unitario,  // Recalcular subtotal
        ]);

        return response()->json($detalleVenta);
    }

    /**
     * Eliminar un detalle de venta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detalleVenta = DetalleVenta::find($id);

        if (!$detalleVenta) {
            return response()->json(['message' => 'Detalle de venta no encontrado'], 404);
        }

        $detalleVenta->delete();

        return response()->json(['message' => 'Detalle de venta eliminado con éxito']);
    }
}
