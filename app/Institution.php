<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Institution extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'institutiontype_id', 'url', 'lng', 'lat'
    ];
    
    /**
     * The booting method of the model. It has been overwritten to exclude soft-deleted records from queries
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access protected
     * @static
     */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('deleted', function (Builder $builder) {
           $builder->where('institutions.deleted', '=', '0'); 
        });
    }

    /**
     * Get the users associated with the given institution
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'institution_users')->withTimestamps();
    }

    /**
     * Get the institutiontype associated with the given institution
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institutiontype()
    {
        return $this->belongsTo('App\Institutiontype', 'institutiontype_id');
    }

    /**
     * Get the tags associated with the given institution
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'institution_tags')->withTimestamps();
    }
    
    /**
     * Get the sigs associated with this institutions
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sigs()
    {
        return $this->belongsToMany('App\Sig', 'sig_institutions');
    }
}
