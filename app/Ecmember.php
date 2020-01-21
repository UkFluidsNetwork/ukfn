<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ecmember extends Model
{

    /**
     * Get the user associated with a given ec member
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the photo associated with a given ec member
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File');
    }
}
