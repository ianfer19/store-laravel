<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'factura';
    protected $primaryKey = 'id_factura';
    public $timestamps = false; // Desactiva timestamps automáticos si no tienes created_at y updated_at

    protected $fillable = [
        'id_venta',
        'fecha_factura',
        'monto_total',
        'estado',
        'metodo_pago'
    ];

    /**
     * Relación con la venta
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }
}
