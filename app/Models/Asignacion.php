<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';
    protected $primaryKey = 'id_asignacion'; 

    use HasFactory;
    protected $fillable = [
        'id_docente', 
        'id_materia', 
        'grupo', 
        'dictamen', 
        'resolucion', 
        'gestion', 
        'documento',
        'anio',
        'id_reasignacion',
        'periodo',
        'id_apoyo'];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia');
    }
    public function designacion()
    {
        return $this->belongsTo(Designacion::class, 'id_designacion');
    }
    public function reasignacion()
    {
        return $this->belongsTo(Reasignacion::class, 'id_reasignacion');
    }

    public function consultores()
    {
        return $this->hasManyThrough(Consultor::class, Docente::class);
    }
    public function apoyo()
    {
        return $this->belongsTo(Apoyo::class, 'id_apoyo');
    }

    public $timestamps = false;
}
