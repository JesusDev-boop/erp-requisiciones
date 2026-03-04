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
    Schema::table('purchase_requests', function (Blueprint $table) {

        $table->string('solicitante')->after('pozo');
        $table->string('contacto')->nullable()->after('supplier_id');
        $table->string('direccion')->nullable()->after('contacto');
        $table->string('rfc')->nullable()->after('direccion');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
