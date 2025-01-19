<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Degree extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id','code', 'name', 'description', 'is_default'];

    public function persons()
    {
        return $this->hasMany(Person::class);
    }
}
