<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'unit_code', 'unit_name',
        ];
    use HasFactory;
    public function product(){
        return $this->hasMany(Product::class,'unit','id');
    }
    public function formatted(){
        return $this->unit_name .'_'. $this->unit_code;
    }
}
