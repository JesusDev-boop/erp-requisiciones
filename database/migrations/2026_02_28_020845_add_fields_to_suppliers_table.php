<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('suppliers', function (Blueprint $table) {
        $table->string('nombre');
        $table->string('razon_social');
        $table->string('rfc')->unique();
        $table->string('contacto')->nullable();
        $table->string('direccion')->nullable();
        $table->boolean('activo')->default(true);
    });
}

public function down(): void
{
    Schema::table('suppliers', function (Blueprint $table) {
        $table->dropColumn([
            'nombre',
            'razon_social',
            'rfc',
            'contacto',
            'direccion',
            'activo'
        ]);
    });
}
};
