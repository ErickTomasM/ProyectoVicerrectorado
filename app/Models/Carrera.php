<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Carrera extends Model
{
    use HasFactory;
    protected $table = 'carreras';
    protected $primaryKey = 'id_programa';
    protected $fillable = [
      'id_programa','programa', 'id_facultad', 'telefono', 'email', 'director'
    ];

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad', 'id_facultad');
    }
    public function materias()
    {
        return $this->hasMany(Materia::class);
    }
    public function docentes()
    {
        return $this->hasMany(Docente::class, 'id_programa', 'id_programa');
    }
    
    public function users()
    {
        return $this->hasMany(User::class, 'id_carrera');
    }
    public function designaciones()
    {
        return $this->hasMany(Designacion::class, 'id_designacion');
    }
    public function apoyo()
{
    return $this->hasMany(Apoyo::class, 'id_programa');
}
    
    public $timestamps = false;
    public $incrementing = false;
}

