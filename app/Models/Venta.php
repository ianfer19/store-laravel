<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';
    protected $primaryKey = 'id_venta';
    public $timestamps = false; // Desactiva timestamps automáticos si no tienes created_at y updated_at

    protected $fillable = [
        'id_usuario',
        'fecha_venta',
        'total'
    ];

    /**
     * Relación con el comprador (usuario)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación con los detalles de venta
     */
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }
}
