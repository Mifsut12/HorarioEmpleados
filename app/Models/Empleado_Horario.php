<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\empleado;
use App\Models\horario;


class Empleado_Horario extends Model
{

    protected $table = 'empleado-horarios';
    protected $fillable = ['ID_Empleado', 'ID_Horario'];
    public $timestamps = false;
    public function empleado():BelongsTo{
        return $this->belongsTo(empleado::class, 'ID_Empleado');
    }

    public function horario():BelongsTo{
        return $this->belongsTo(horario::class, 'ID_Horario');
    }
}
