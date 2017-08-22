<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Sigbox extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content', 'order', 'active',
                           'sig_id', 'user_id'];

    /**
     * Get the SIG this box belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function sig()
    {
        return $this->belongsTo('App\Sig');
    }

    /**
     * Get the user that created this box
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Determine if the box is enabled
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active === 1;
    }

    /**
     * Determine if the box is enabled or disabled
     *
     * @return string
     */
    public function status()
    {
        return $this->isActive() ? "Enabled" : "Disabled";
    }
}

