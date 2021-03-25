<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email','email_verified', 'password','mobile','mobile_verified',
        'shipping_address','billing_address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function shipments(){
        return $this->hasMany(Shipment::class);
    }

    public function shippingAddress(){
        return $this->hasOne(Address::class,'id','shipping_address');
    }

    public function billingAddress(){
        return $this->hasOne(Address::class,'id','billing_address');
    }
    public function wishList(){
        return $this->hasOne(WishList::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    public function formattedName(){
        return $this->first_name.''.$this->last_name;
    }
}
