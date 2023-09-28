<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designacion extends Model
{
    protected $table = 'designaciones';
    protected $primaryKey = 'id_designacion'; 

    use HasFactory;
    protected $fillable = [
        'id_docente',
        'id_materia',
        'dictamen',
        'resolucion',
        'gestion',
        'id_programa',
        'documento',
        'anio',
        'fecha_desig'

        
    ];

    public function docentes()
    {
        return $this->hasManyThrough(Docente::class, Asignacion::class, 'id_designacion', 'id_docente');
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
        return $this->HasMany(Asignacion::class, 'id_designacion');
    }
    public function consultores()
    {
    return $this->hasMany(Consultor::class, 'id_designacion');
    }

    public $timestamps = false;
}
