<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbienteCarrera extends Model
{
    use HasFactory;

    protected $table = 'ambientes_carrera';
    public $timestamps = false;
    protected $primaryKey = 'id_ambientes_carrera';

    protected $fillable = [
        'id_ambiente',
        'id_programa',
        '_estado',
        'id_gestion',
        'id_periodo'
    ];

    public function ambiente()
    {
        return $this->belongsTo(Ambiente::class, 'id_ambiente');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_programa');
    }
}
