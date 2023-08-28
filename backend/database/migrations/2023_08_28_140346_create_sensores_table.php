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
      $table->enum('nombre', ['S1', 'S2', 'S3', 'S4']);
      $table->dateTime('fecha_medida');
      $table->float('valor');
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
