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
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn(['slug', 'qr_code_path', 'clicks']); // Eliminar múltiples columnas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            // Volver a agregar las columnas si se revierte la migración
            $table->string('slug', 191)->unique()->nullable();
            $table->string('qr_code_path', 2083)->nullable();
            $table->unsignedInteger('clicks')->default(0);
        });
    }
};
