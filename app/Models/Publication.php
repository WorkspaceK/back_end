<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    public function Persons()
    {
        return $this->belongsTo('App\Models\Publication', 'main_person_id', 'id');
    }

}
