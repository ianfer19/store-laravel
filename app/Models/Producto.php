<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false; // Desactiva timestamps automáticos si no tienes created_at y updated_at

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'cantidad_disponible',
        'id_vendedor',
        'fecha_creacion'
    ];

    /**
     * Relación con el vendedor (user)
     */
    public function vendedor()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }
}
