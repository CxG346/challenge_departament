<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    use HasFactory;

    protected $table = 'departament';
    protected $fillable = ['name ', 'ambassador', 'departament_dad_id '];

    public function ambassador()
    {
        return $this->belongsTo(Employee::class, 'ambassador');
    }

    public function departament_dad_id()
    {
        return $this->belongsTo(Departament::class, 'departament_dad_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    
}
