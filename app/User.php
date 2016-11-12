<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'title_id', 'group_id', 'department_id', 'orcidid', 'url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the institutions associated with the given user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function institutions()
    {
        return $this->belongsToMany('App\Institution', 'institution_users')->withTimestamps();
    }

    /**
     * Get the sigs associated with the given user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sigs()
    {
        return $this->belongsToMany('App\Sig', 'sig_users')->withTimestamps();
    }

    /**
     * Get the tags associated with the given user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'user_tags')->withTimestamps();
    }

    /**
     * Get the title associated with the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function title()
    {
        return $this->hasOne('App\Title');
    }

    /**
     * Get the group associated with the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group()
    {
        return $this->hasOne('App\Group');
    }

    /**
     * Get the group associated with the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function department()
    {
        return $this->hasOne('App\Department');
    }

    /**
     * Get the subscription associated with the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription()
    {
        return $this->hasOne('App\Subscription');
    }

    /**
     * Get the news associated with the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news()
    {
        return $this->hasMany('App\News');
    }

    /**
     * Get the events associated with the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Event');
    }

    /**
     * Get the list of tag ids associated with the user
     * 
     * @access public
     * @return array
     */
    public function getTagIds()
    {
        return $this->tags->lists('id')->toArray();
    }

    /**
     * Get the list of institution ids associated with the user
     * 
     * @access public
     * @return array
     */
    public function getInstitutionIds()
    {
        return $this->institutions->lists('id')->toArray();
    }
}
