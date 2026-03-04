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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();

$table->string('num_requisicion')->nullable()->unique();
$table->string('solicitud_trabajo')->nullable();
$table->string('pozo')->nullable();

$table->date('fecha_requisicion');
$table->date('fecha_requerida');

$table->enum('estatus', [
    'borrador',
    'en_revision',
    'numerada',
    'aprobada',
    'rechazada'
])->default('borrador');

$table->foreignId('user_id')->constrained();
$table->foreignId('area_id')->constrained();
$table->foreignId('project_id')->constrained();
$table->foreignId('supplier_id')->constrained();

$table->enum('moneda',['nacional','dolares']);
$table->enum('condicion_pago',[
    'credito',
    'credito_15',
    'credito_30',
    'credito_60',
    'credito_90',
    'contado'
]);

$table->decimal('subtotal',15,2)->default(0);
$table->decimal('descuento',15,2)->default(0);
$table->decimal('iva',15,2)->default(0);
$table->decimal('retencion_iva',15,2)->default(0);
$table->decimal('retencion_isr',15,2)->default(0);
$table->decimal('total',15,2)->default(0);
$table->text('total_letra')->nullable();

$table->foreignId('created_by')->nullable();
$table->foreignId('updated_by')->nullable();

$table->timestamps();
$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
