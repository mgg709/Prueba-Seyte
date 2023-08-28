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
    Schema::create('clients', function (Blueprint $table) {
      $table->integer('codigo')->primary();
      $table->string('razon_social');
      $table->integer('cif');
      $table->string('direccion');
      $table->string('municipio');
      $table->string('provincia');
      $table->date('fecha_inicio');
      $table->date('fecha_expiracion');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('clients');
  }
};
