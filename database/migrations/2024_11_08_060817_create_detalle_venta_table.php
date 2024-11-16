<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentaTable extends Migration
{
    public function up()
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->id('id_venta');
            $table->foreignId('id_usuario')->constrained('users'); // Relación con users
            $table->timestamp('fecha_venta')->useCurrent();
            $table->decimal('total', 10, 2);
        });

        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->foreignId('id_venta')->constrained('venta', 'id_venta'); // Ajuste en el nombre de columna
            $table->foreignId('id_producto')->constrained('productos', 'id_producto'); // Ajuste en el nombre de columna
            $table->integer('cantidad')->unsigned();
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2)->storedAs('cantidad * precio_unitario');
        });
        Schema::create('factura', function (Blueprint $table) {
            $table->id('id_factura');
            $table->foreignId('id_venta')->constrained('venta', 'id_venta'); // Ajuste en el nombre de columna
            $table->timestamp('fecha_factura')->useCurrent();
            $table->decimal('monto_total', 10, 2);
            $table->string('estado', 50);
            $table->string('metodo_pago', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venta');
        Schema::dropIfExists('detalle_venta');
        Schema::dropIfExists('factura');
    }
}
