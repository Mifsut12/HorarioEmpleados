<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class local extends Model
{
    public function empleados(): HasMany{
        return $this->hasMany(Employee::class);
    }

    public $timestamps = false;
}
