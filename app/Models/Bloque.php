<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    use HasFactory;

    protected $table = 'bloque';
    public $timestamps = false;
    protected $primaryKey = 'id_bloque';

    protected $fillable = [
        'id_bloque_old',
        'bloque',
        'id_campus',
        '_estado',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'id_campus');
    }

    public function ambientes()
    {
        return $this->hasMany(Ambiente::class, 'id_bloque');
    }
}
