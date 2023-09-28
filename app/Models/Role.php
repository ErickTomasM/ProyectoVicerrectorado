<?php

namespace App\Models;
use Spatie\Permission\Models\Role as SpatieRole;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends SpatieRole
{
    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'id_facultad');
    }
}
