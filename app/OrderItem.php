<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    protected $fillable = ['order', 'product', 'qty', 'price'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'orderitems';

    public function order() {
        return $this->belongsTo('App\Order', 'order')->first();
    }

    public function product() {
        return $this->belongsTo('App\Product', 'product')->withTrashed()->first();
    }
}
