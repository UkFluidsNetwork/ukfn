<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institutiontype extends Model
{

    /**
     * Get the institutions associated with the given institutiontype
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function institutions()
    {
        return $this->hasMany('App\Institution');
    }
}
