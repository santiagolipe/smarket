<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    use SoftDeletes;

    protected $fillable = ['user', 'name', 'qty', 'brand', 'dept', 'weight', 'price', 'desc', 'image'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'products';

    public function user() {
        return $this->belongsTo('App\User', 'user')->first();
    }
}
