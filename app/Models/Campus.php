<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Campus extends Model
{
    use HasFactory;

    protected $table = 'campus';
    protected $primaryKey = 'id_campus';
    public $timestamps = false;
    
    // Relación uno a muchos con Bloque
    public function bloques()
    {
        return $this->hasMany(Boque::class, 'id_campus');
    }
    
    // Relación uno a muchos con Ambiente
    public function ambientes()
    {
        return $this->hasMany(Ambiente::class, 'id_campus');
    }
}
