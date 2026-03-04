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
        Schema::create('purchase_request_items', function (Blueprint $table) {
              $table->id();
$table->foreignId('purchase_request_id')->constrained()->cascadeOnDelete();

$table->integer('item');
$table->decimal('cantidad',15,4);
$table->foreignId('unit_id')->constrained();
$table->text('descripcion');
$table->decimal('precio_unitario',15,4);
$table->decimal('total',15,2);

$table->timestamps();
$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};
