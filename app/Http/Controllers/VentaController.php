<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 

class VentaController extends Controller
{
    /**
     * Mostrar todas las ventas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener el ID del usuario autenticado
        $usuarioId = Auth::id();
    
        // Obtener las ventas del usuario autenticado con sus relaciones
        $ventas = Venta::with(['usuario', 'detalles'])
                       ->where('id_usuario', $usuarioId)
                       ->get();
    
        return view('ventas.index', compact('ventas'));  // Pasar las ventas a la vista 'ventas.index'
    }
    
    public function store(Request $request)
{
    try {
        // Validar los datos de la solicitud
        $request->validate([
            'total' => 'required|numeric',
            'productos' => 'required|array',
        ]);

        // Asegurarnos de que el total sea un número flotante
        $total = (float) $request->total;

        // Crear la venta
        $venta = Venta::create([
            'id_usuario' => Auth::id(),
            'fecha_venta' => now(),
            'total' => $total,
        ]);

        // Retornar el id de la venta creada
        return response()->json(['id_venta' => $venta->id_venta], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Errores de validación
        return response()->json(['error' => 'Error de validación: ' . $e->getMessage()], 422);
    } catch (\Exception $e) {
        // Errores generales (problemas con base de datos, etc.)
        return response()->json(['error' => 'Hubo un problema al crear la venta: ' . $e->getMessage()], 500);
    }
}

    

    /**
     * Mostrar una venta específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venta = Venta::with(['usuario', 'detalles'])->find($id);  // Obtener venta con relaciones

        if (!$venta) {
            return redirect()->route('ventas.index')->with('error', 'Venta no encontrada');
        }

        return view('ventas.show', compact('venta'));  // Pasar la venta a la vista 'ventas.show'
    }

    /**
     * Mostrar el formulario para editar una venta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return redirect()->route('ventas.index')->with('error', 'Venta no encontrada');
        }

        return view('ventas.edit', compact('venta'));  // Pasar la venta a la vista 'ventas.edit'
    }

    /**
     * Actualizar una venta existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return redirect()->route('ventas.index')->with('error', 'Venta no encontrada');
        }

        // Validación de los datos recibidos
        $request->validate([
            'total' => 'required|numeric',
        ]);

        // Actualizar la venta
        $venta->update([
            'total' => $request->total,
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada con éxito');  // Redirigir a la lista de ventas
    }

    /**
     * Eliminar una venta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return redirect()->route('ventas.index')->with('error', 'Venta no encontrada');
        }

        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada con éxito');  // Redirigir a la lista de ventas
    }



    public function dashboard()
    {
        $usuarioId = Auth::id();
        
        // Ventas donde el usuario es comprador
        $ventasCompras = DB::table('venta')
            ->selectRaw('YEAR(fecha_venta) as year, MONTH(fecha_venta) as month, SUM(total) as total_compras')
            ->where('id_usuario', $usuarioId)
            ->groupBy(DB::raw('YEAR(fecha_venta), MONTH(fecha_venta)'))
            ->get();
        
        // Ventas donde el usuario es vendedor
        $ventasVentas = DB::table('venta as v')
            ->join('detalle_venta as d', 'v.id_venta', '=', 'd.id_venta')
            ->join('productos as p', 'd.id_producto', '=', 'p.id_producto')  // Hacer JOIN con productos para obtener id_vendedor
            ->selectRaw('YEAR(v.fecha_venta) as year, MONTH(v.fecha_venta) as month, SUM(v.total) as total_ventas')
            ->where('p.id_vendedor', $usuarioId)  // Ahora se utiliza id_vendedor de la tabla productos
            ->groupBy(DB::raw('YEAR(v.fecha_venta), MONTH(v.fecha_venta)'))
            ->get();
        
        // Obtener los detalles de ventas (productos comprados y fecha de compra)
        $detallesVentas = DB::table('venta as v')
            ->join('detalle_venta as d', 'v.id_venta', '=', 'd.id_venta')
            ->join('productos as p', 'd.id_producto', '=', 'p.id_producto')
            ->select('v.fecha_venta', 'p.nombre as producto', 'd.cantidad', 'd.precio_unitario', 'd.subtotal')
            ->where('v.id_usuario', $usuarioId)  // Solo ventas donde el usuario es comprador
            ->get();
    
        return view('dashboard.index', compact('ventasCompras', 'ventasVentas', 'detallesVentas'));
    }
    
}
