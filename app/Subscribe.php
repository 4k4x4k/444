<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    const UPDATED_AT = null;

    protected $table = 'subscribes';
    protected $primaryKey = 'email';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function user()
    {
        $this->belongsTo('App\User', 'fk_id_user');
    }
}
