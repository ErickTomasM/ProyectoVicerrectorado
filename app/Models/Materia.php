<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    
   
    protected $table = 'materias';
    protected $primaryKey = 'id_materia';
    protected $fillable = [
        'id_materia',
        'sigla',
        'materia',
        'hrs_teoricas',
        'hrs_practicas',
        'id_programa',
    ];
    
    public function docentes(){
        return $this->belongsToMany(Docente::class, 'asignacions');
    }
    
    public function carreras()
    {
    return $this->belongsTo(Carrera::class, 'id_programa');
    }
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_materia');
    }
    
    public function apoyo()
    {
        return $this->hasMany(Apoyo::class, 'id_materia');
    }
    

    public $timestamps = false;
}
