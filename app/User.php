<?php

namespace App;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function notifs($request)
    {
        $sort_array = ['Ascending' => 'asc', 'Descending' => 'desc'];
        $sort_by_array = ['Date' => 'created_at', 'Type' => 'notifiable_type'];

        return $this -> morphMany(DatabaseNotification::class, "notifiable")
            ->orderBy('read_at','desc')
            ->orderBy($sort_by_array[$request->sortBy], $sort_array[$request->sort])->limit(10)->offset($request->offset);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $dates = ['deactivated_at'];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
