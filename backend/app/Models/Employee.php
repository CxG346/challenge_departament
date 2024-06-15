<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    protected $fillable = ['departament_id', 'level', 'name'];

    public function departament_id()
    {
        return $this->belongsTo(Departament::class, 'departament_id');
    }
}
