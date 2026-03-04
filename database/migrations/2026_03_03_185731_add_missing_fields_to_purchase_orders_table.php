<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('purchase_orders', function (Blueprint $table) {

        $table->string('numero_requisicion')->nullable()->after('numero_oc');

        $table->string('proveedor_contacto')->nullable()->after('proveedor_nombre');

        $table->string('pozo')->nullable()->after('proveedor_direccion');

        $table->string('solicitud_trabajo')->nullable()->after('proyecto');

        $table->date('fecha')->nullable()->after('solicitante');

        $table->string('cotizacion')->nullable()->after('moneda');
    });
}

    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::table('purchase_orders', function (Blueprint $table) {

        $table->dropColumn([
            'numero_requisicion',
            'proveedor_contacto',
            'pozo',
            'solicitud_trabajo',
            'fecha',
            'cotizacion'
        ]);
    });
}
};
