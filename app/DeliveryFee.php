<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryFee extends Model {
    protected $fillable = ['user', 'localization', 'localizationraw', 'time', 'fee'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = "deliveryfees";
}
