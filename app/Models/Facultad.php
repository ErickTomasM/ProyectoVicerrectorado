<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    use HasFactory;
    protected $table = 'facultades';
    protected $primaryKey = 'id_facultad';
    protected $fillable = [
        'id_facultad', 'facultad', 'telefono', 'id_docente', 'email', 'autoridad',
    ];
    public function carreras()
    {
        return $this->hasMany(Carrera::class, 'id_facultad', 'id_facultad');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'id_facultad', 'id_facultad');
    }
    public function roles()
{
    return $this->hasMany(Role::class, 'id_facultad');
}
public function decano()
{
    return $this->belongsTo(Docente::class, 'id_docente');
}
    //------
    public $timestamps = false;
}
