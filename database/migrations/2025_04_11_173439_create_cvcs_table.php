<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('csvs', function (Blueprint $table) {
            $table->id();
            $table->string('hash');
            $table->string('csv')->nullable();
            $table->string('DNI');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('correo')->unique();
            $table->string('archivo');
            $table->enum('tipo_documento', ['Certificado matricula', 'Titulo academico', 'Archivo empresarial', 'Archivo estado'])
                  ->default('Certificado matricula');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE csvs AUTO_INCREMENT = 1000001');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvcs');
    }
};
