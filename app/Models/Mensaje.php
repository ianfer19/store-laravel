<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'mensajes';

    protected $fillable = [
        'id_usuario_emisor',
        'id_usuario_destino',
        'contenido',
        'estado_lectura',
        'fecha_enviado',
        'fecha_recibido',
    ];

    // Deshabilitar el uso de created_at y updated_at
    public $timestamps = false;

    public function emisor()
    {
        return $this->belongsTo(User::class, 'id_usuario_emisor');
    }

    public function destino()
    {
        return $this->belongsTo(User::class, 'id_usuario_destino');
    }
}
