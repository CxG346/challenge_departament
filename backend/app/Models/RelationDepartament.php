<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationDepartament extends Model
{
    use HasFactory;

    protected $table = 'relation_departament';
    protected $fillable = ['departament_dad_id', 'departament_son_id'];
}
