<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sensor extends Model
{
  use HasFactory;

  protected $fillable = [
    'nombre',
    'fecha_medida',
    'valor'
  ];

  public function programador(): BelongsTo
  {
    return $this->belongsTo(Programador::class, 'numero_serie');
  }
}
