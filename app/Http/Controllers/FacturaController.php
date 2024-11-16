<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Venta;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /**
     * Mostrar todas las facturas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturas = Factura::all();
        return response()->json($facturas);
    }

    /**
     * Crear una nueva factura.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'id_venta' => 'required|exists:venta,id_venta',  // La venta debe existir
            'monto_total' => 'required|numeric',
            'estado' => 'required|string|max:50',
            'metodo_pago' => 'required|string|max:50',
        ]);

        // Crear la factura
        $factura = Factura::create([
            'id_venta' => $request->id_venta,
            'fecha_factura' => now(),  // Fecha de creación automática
            'monto_total' => $request->monto_total,
            'estado' => $request->estado,
            'metodo_pago' => $request->metodo_pago,
        ]);

        return response()->json($factura, 201); // Responder con la factura creada
    }

    /**
     * Mostrar una factura específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $factura = Factura::find($id);

        if (!$factura) {
            return response()->json(['message' => 'Factura no encontrada'], 404);
        }

        return response()->json($factura);
    }

    /**
     * Actualizar una factura existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $factura = Factura::find($id);

        if (!$factura) {
            return response()->json(['message' => 'Factura no encontrada'], 404);
        }

        // Validación de los datos recibidos
        $request->validate([
            'monto_total' => 'required|numeric',
            'estado' => 'required|string|max:50',
            'metodo_pago' => 'required|string|max:50',
        ]);

        // Actualizar la factura
        $factura->update([
            'monto_total' => $request->monto_total,
            'estado' => $request->estado,
            'metodo_pago' => $request->metodo_pago,
        ]);

        return response()->json($factura);
    }

    /**
     * Eliminar una factura.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $factura = Factura::find($id);

        if (!$factura) {
            return response()->json(['message' => 'Factura no encontrada'], 404);
        }

        $factura->delete();

        return response()->json(['message' => 'Factura eliminada con éxito']);
    }
}
