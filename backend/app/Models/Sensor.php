<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sensor extends Model
{
  use HasFactory;

  protected $table = 'sensores';

  protected $fillable = [
    'sonda',
    'fecha_medida',
    'valor',
    'programadores_numero_serie'
  ];

  public function programador(): BelongsTo
  {
    return $this->belongsTo(Programador::class, 'numero_serie');
  }
}
