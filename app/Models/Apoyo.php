<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apoyo extends Model
{
    use HasFactory;
    
    protected $table = 'apoyo';
    protected $primaryKey = 'id_apoyo';
    protected $fillable = ['id_materia', 'id_programa', 'id_carrera'];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia');
    }

    public function programa()
    {
        return $this->belongsTo(Carrera::class, 'id_programa');
    }
    public function carrera()
    {
    return $this->belongsTo(Carrera::class,'id_programa');
    }
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'id_apoyo');
    }
    public $timestamps = false;
}
