<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;

    protected $table = 'ambientes';
    protected $primaryKey = 'id_ambiente';
    public $timestamps = false;
    protected $fillable = [
        'id_ambiente_old',
        'id_campus',
        'id_bloque_old',
        'nro_ambiente',
        'nro_piso',
        'img_campus',
        'img_bloque',
        'exterior',
        'interior',
        'capacidad',
        'tipo_pizarra',
        'obs',
        'tipo',
        'id_bloque',
        'pupitres',
        '_registrado',
        '_modificado',
        '_estado'
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'id_campus');
    }

    public function bloque()
    {
        return $this->belongsTo(Bloque::class, 'id_bloque');
    }

    public function ambientesCarrera()
    {
        return $this->hasMany(AmbienteCarrera::class, 'id_ambiente');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_ambiente');
    }
}