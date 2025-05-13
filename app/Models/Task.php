<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'id', 'title', 'description', 'deadline',
        'group_id', 'executor',
    ];
    
}
