<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajeTable extends Migration
{
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id('id_chat');
            $table->foreignId('id_usuario_emisor')->constrained('users'); // Relación con users (emisor)
            $table->foreignId('id_usuario_destino')->constrained('users'); // Relación con users (destino)
            $table->text('contenido'); // Mensaje enviado
            $table->boolean('estado_lectura')->default(false); // Estado de lectura
            $table->timestamp('fecha_enviado')->useCurrent(); // Fecha de envío
            $table->timestamp('fecha_recibido')->nullable(); // Fecha de recepción, puede ser nulo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
}
