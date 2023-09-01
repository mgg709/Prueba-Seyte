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
    Schema::create('sensores', function (Blueprint $table) {
      $table->id();
      $table->enum('sonda', ['S1', 'S2', 'S3', 'S4']);
      $table->dateTime('fecha_medida')->nullable();
      $table->float('valor')->nullable();
      $table->integer('programadores_numero_serie');
      $table->foreign('programadores_numero_serie')->references('numero_serie')->on('programadores')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sensores');
  }
};
