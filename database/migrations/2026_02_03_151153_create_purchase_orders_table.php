<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('purchase_orders', function (Blueprint $table) {

        $table->id();
        $table->foreignId('purchase_request_id')->nullable();

        $table->string('numero_oc')->unique();

        $table->string('proveedor_nombre');
        $table->string('proveedor_rfc')->nullable();
        $table->text('proveedor_direccion')->nullable();

        $table->string('solicitante');
        $table->string('area')->nullable();
        $table->string('proyecto')->nullable();

        $table->string('condiciones_pago');
        $table->string('moneda');

        $table->decimal('subtotal',15,2);
        $table->decimal('descuento',15,2)->default(0);
        $table->decimal('iva',15,2)->default(0);
        $table->decimal('retencion_iva',15,2)->default(0);
        $table->decimal('retencion_isr',15,2)->default(0);
        $table->decimal('total',15,2);

        $table->string('total_letra');

        $table->enum('estatus',['borrador','emitida','cancelada'])
              ->default('borrador');

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
