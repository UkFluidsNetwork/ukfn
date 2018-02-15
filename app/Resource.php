<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
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
     * Get the tutorials associated with this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tutorials()
    {
        return $this->hasMany('App\Tutorial')->orderBy('priority');
    }

    /**
     * Get the user who added the resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the tags associated with this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'resource_tags')->withTimestamps();
    }

    /**
     * Get the tags associated with this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplines()
    {
        return $this->belongsToMany('App\Tag', 'resource_tags')
            ->where('tags.tagtype_id', 1)
            ->withTimestamps();
    }

    /**
     * Determine if the course is enabled
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active === 1;
    }

    /**
     * Determine if the course is enabled or disabled
     *
     * @return string
     */
    public function status()
    {
        return $this->isActive() ? "Enabled" : "Disabled";
    }
}
