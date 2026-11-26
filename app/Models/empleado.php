<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\local;
use Illuminate\Foundation\Auth\User as Authenticatable;

class empleado extends Authenticatable
{
    public function local(): BelongsTo{
        return $this->belongsTo(local::class, 'ID_Local');
    }

    public $timestamps = false;

    protected $table = "empleados";
}
