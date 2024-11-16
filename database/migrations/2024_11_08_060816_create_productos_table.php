<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad_disponible');
            $table->foreignId('id_vendedor')->constrained('users'); // Relación con users (vendedor)
            $table->timestamp('fecha_creacion')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
