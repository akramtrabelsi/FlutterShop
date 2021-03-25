<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $primaryKey = 'id';
    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function states(){
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    use HasFactory;
}
