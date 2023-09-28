<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reasignacion extends Model
{
    protected $table = 'reasignaciones';
    protected $primaryKey = 'id_reasignacion';
    public $timestamps = false;

    protected $fillable = [
        'dictamen',
        'resolucion',
        'periodo',
        'gestion',
        'documento',
        'anio',
        'fecha_reasig',
        'id_programa',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia');
    }
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_programa');
    }
    public function asignaciones()
    {
        return $this->HasMany(Asignacion::class, 'id_reasignacion');
    }
}
