<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    const type = "cliente";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'surname', 'phone', 'address', 'number', 'district', 'complement',
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
    protected $table = "clientes";

    /**
     * Get the user record in which this 'cliente' belongs to.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user')->first();
    }
}
