<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    const UPDATED_AT = null;

    public function user()
    {
        $this->belongsTo('App\User', 'fk_id_user');
    }
}
