<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sig extends Model
{

    /**
     * Get the users associated with the given sig
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'sig_users')->withTimestamps();
    }

    /**
     * Get the institution associated with the given sig
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function institutions()
    {
        return $this->belongsToMany('App\Institution', 'sig_institutions')->withTimestamps();
    }
    
    /**
     * Get the tags associated with the given sig
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'sig_tags')->withTimestamps();
    }
}
