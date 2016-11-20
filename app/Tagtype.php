<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagtype extends Model
{

    /**
     * Get the tags associated with the given tagtype
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function tags()
    {
        return $this->hasMany('App\Tag');
    }
}
