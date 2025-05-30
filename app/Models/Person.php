<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = ['id', 'firstName', 'lastName'];

    public function publications()
    {
        return $this->hasMany('App\Models\Publication', 'main_person_id', 'id');
    }

    public function degrees()
    {
        return $this->belongsTo('App\Models\Degree', 'degree_id', 'id');
    }
}
