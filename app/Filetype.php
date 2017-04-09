<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filetype extends Model
{

    /**
     * Get the files of this type
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function files()
    {
        return $this->hasMany('App\File');
    }
}
