<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable= [
        'street_name' , 'street_number','city','country','post_code'
    ];

    public function user (){
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
