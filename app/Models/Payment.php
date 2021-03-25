<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable=[
        'amount','user_id','order_id',
        'paid_on','payment_reference',
    ];
    use HasFactory;
}
