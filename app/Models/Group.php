<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'id', 'name', 'count_members',
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
