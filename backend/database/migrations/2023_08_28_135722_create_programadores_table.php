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
    Schema::create('programadores', function (Blueprint $table) {
      $table->integer('numero_serie')->primary();
      $table->enum('modelo', ['A', 'B', 'C']);
      $table->date('fecha_alta');
      $table->date('fecha_ultima_conexion');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('programadores');
  }
};
