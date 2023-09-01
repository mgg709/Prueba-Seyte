<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Programador extends Model
{
  use HasFactory;

  protected $primaryKey = 'numero_serie';
  protected $table = 'programadores';
  protected $fillable = [
    'numero_serie',
    'modelo',
    'fecha_alta',
    'fecha_ultima_conexion',
    'clientes_codigo'
  ];

  public function cliente(): BelongsTo
  {
    return $this->belongsTo(Cliente::class, 'clientes_codigo');
  }

  public function sensores(): HasMany
  {
    return $this->hasMany(Sensor::class, 'numero_serie');
  }
}
