<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
  use HasFactory;

  protected $primaryKey = 'codigo';

  protected $fillable = [
    'razon_social',
    'cif',
    'direccion',
    'municipio',
    'provincia',
    'fecha_inicio',
    'fecha_expiracion'
  ];

  public function programadores(): HasMany
  {
    return $this->hasMany(Programador::class, 'codigo');
  }
}
