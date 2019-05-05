<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name', 'reg', 'email', 'type', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = "users";

    /**
    * Get the record of the type belonging to this user.
    */
    public function extra() {
        return $this->hasOne('App\\' . ucfirst($this->type), 'user');
    }

    public function lojista() {
        return $this->hasOne('App\Lojista', 'user');
    }

    public function orders() {
        return $this->hasMany('App\Order', 'user');
    }

    public function marketOrders() {
        return $this->hasMany('App\Order', 'market');
    }

    public function marketProducts() {
        return $this->hasMany('App\Product', 'user');
    }
}
