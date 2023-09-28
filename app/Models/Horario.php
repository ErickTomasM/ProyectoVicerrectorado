<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Horario extends Model
{
    protected $table = 'horarios';
    protected $primaryKey = 'id_horario';
    public $timestamps = false;

    protected $fillable = [
        'id_asignacion',
        'id_ambientes_carrera',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];

    public function asignacion()
    {
        return $this->belongsTo(Asignacion::class, 'id_asignacion');
    }

    public function ambienteCarrera()
    {
        return $this->belongsTo(AmbienteCarrera::class, 'id_ambientes_carrera');
    }
}
