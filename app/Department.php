<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    /**
     * Get the users associated with the given department
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
