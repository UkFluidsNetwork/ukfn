<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutorial extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'author', 'description',
        'date', 'priority', 'resource_id', 'active'];

    /**
     * Get the files that belong to this tutorial
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('App\File');
    }

    /**
     * Get the resource that this tutorial belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resources()
    {
        return $this->belongsTo('App\Resource');
    }

    /**
     * Determine if the tutorial is enabled
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active === 1;
    }

    /**
     * Determine if the tutorial is enabled or disabled
     *
     * @return string
     */
    public function status()
    {
        return $this->isActive() ? "Enabled" : "Disabled";
    }
}
