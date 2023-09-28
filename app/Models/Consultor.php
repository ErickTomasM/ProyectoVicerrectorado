<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultor extends Model
{
    use HasFactory;
    protected $table = 'consultores';
    protected $primaryKey = 'id_consultor';

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }

    public function designacion()
    {
        return $this->belongsTo(Designacion::class, 'id_designacion');
    }
    public $timestamps = false;
}
