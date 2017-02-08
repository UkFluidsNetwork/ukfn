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
     * Compare old and new tags to determine which ones we are deleting (in old but not in  new) and which ones we are adding (in new but not in old)
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @param array $tags Multidimensional array containing an array per tagtype
     * @return void
     */
    public function updateTags($tags)
    {
        $tagtypes = ['disciplines' => 1, 'applications' => 2, 'techniques' => 3, 'facilities' => 4];

        $currentTags = $this->getTagIds();
        if (!empty($currentTags)) {
            // merge all input tags for comparison
            $inputTags = [];
            foreach ($tagtypes as $type) {
                if (!empty($tags[$type]) && is_array($tags[$type])) {
                    array_merge($inputTags, $tags[$type]);
                }
            }
            // detach all tags that were not input
            foreach ($currentTags as $curTag) {
                if (!in_array($curTag, $inputTags)) {
                    $this->tags()->detach($curTag);
                }
            }
        }

        foreach ($tagtypes as $type => $key) {
            if (!empty($tags[$type])) {
                foreach ($tags[$type] as $element) {
                    $id = is_numeric($element) ? $element : Tag::create(['name' => $element, 'category' => 'Other', 'tagtype_id' => $key]);
                    $this->tags()->attach($id);
                }
            }
        }
    }

    /**
     * Compare old and new institutions to determine which ones we are deleting (in old but not in  new) and which ones we are adding (in new but not in old)
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @param array $institutions
     * @return void
     */
    public function updateInstitutions($institutions)
    {
        $currentInstitutions = $this->getInstitutionIds();
        if (!empty($currentInstitutions)) {
            foreach ($currentInstitutions as $curInstitution) {
                if (!in_array($curInstitution, $institutions)) {
                    $this->institutions()->detach($curInstitution);
                }
            }
        }

        if (!empty($institutions)) {
            foreach ($institutions as $inputInstitution) {
                if (!in_array($inputInstitution, $currentInstitutions)) {
                    $id = is_numeric($inputInstitution) ? $inputInstitution : Institution::create(['name' => $inputInstitution]);
                    $this->institutions()->attach($id);
                }
            }
        }
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function title()
    {
        return $this->belongsTo('App\Title');
    }

    /**
     * Get the group associated with the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    /**
     * Get the group associated with the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Department');
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

    public function sigLeader()
    {
        $userSigLeader = [];
        $userSigs = $this->sigs; 
        // get SIGs that user is associated with
        if (!empty($userSigs)) {

            foreach ($userSigs as $sig) {
            
                $thisSig = Sig::findOrFail($sig->id);
                $thisSig->getLeaderId();

                if (!empty($thisSig->leader[0])) {
                    $thisSigLeader = $thisSig->leader[0]->id;

                    if ($this->id === $thisSigLeader) {
                        $userSigLeader[] = $thisSig->id;
                    }
                }
            
            }
        }
    
        return $userSigLeader;    
        
    }
}
