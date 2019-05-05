<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = ['user', 'market', 'delivery', 'address', 'number', 'district', 'payment', 'subtotal', 'delivery_fee', 'total'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'orders';

    public function items() {
        return $this->hasMany('App\OrderItem', 'order');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user')->first();
    }

    public function market() {
        return $this->belongsTo('App\User', 'market')->first();
    }
}
