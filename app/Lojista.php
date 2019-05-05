<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lojista extends Model {
    const type = "lojista";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'companyname', 'owner', 'desc', 'logo', 'phone', 'address', 'number', 'district', 'complement', 'default_delivery_fee', 'sales',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['user'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = "lojistas";

    /**
     * Get the user record in which this 'lojista' belongs to.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user')->first();
    }
}
