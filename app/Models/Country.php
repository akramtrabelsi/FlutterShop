<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $primaryKey = 'id';
    public function cities(){
        return $this->hasMany(City::class, 'country_id', 'id');
    }
    public function states()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }
    use HasFactory;
}
