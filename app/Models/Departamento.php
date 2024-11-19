<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
         
    ];
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_departamento', 'id_departamento');
    }
}
