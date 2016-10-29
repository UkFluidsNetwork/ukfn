<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{

    /**
     * Get the users associated with the given institution
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Get the institutiontype associated with the given institution
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function institutiontype()
    {
        return $this->hasOne('App\Institutiontype');
    }

    /**
     * Get the tags associated with the given institution
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
