<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    
    use HasFactory;
    protected $table = 'docentes';
    protected $primaryKey = 'id_docente';
    protected $fillable = [
        'nombres',
		'paterno',
		'materno',
		'ci',
		'telefono',
		'abre_titulo',
		'cargo',
        'sexo',
        'email',
        'id_programa',
        'tiempo',
        'tipo_docente',
    ];
    public function materias(){
        return $this->belongsToMany(Materia::class, 'asignacion');
    }
    public function carreras()
    {
        return $this->belongsTo(Carrera::class, 'id_programa', 'id_programa');
    }
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_docente');
    }
    public function facultad()
    {
        return $this->hasOne(Facultad::class, 'id_docente');
    }
    
    public function consultores()
    {
    return $this->hasMany(Consultor::class, 'id_docente');
    }

    public $timestamps = false;
    
}
