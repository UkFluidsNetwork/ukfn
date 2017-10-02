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
        'name', 'surname', 'email', 'password', 'title_id', 'group_id',
        'department_id', 'orcidid', 'url', 'researcher'
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
     * Compare old and new tags to determine which ones we are deleting
     * (in old but not in  new) and which ones we are adding
     * (in new but not in old)
     *
     * @param array $tags Multidimensional array containing an array per tagtype
     * @return void
     */
    public function updateTags($tags)
    {
        $tagtypes = ['disciplines' => 1, 'applications' => 2,
                     'techniques' => 3, 'facilities' => 4];

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
                    $id = is_numeric($element)
                          ? $element
                          : Tag::create(['name' => $element,
                                'category' => 'Other', 'tagtype_id' => $key]);
                    $this->tags()->attach($id);
                }
            }
        }
    }

    /**
     * Compare old and new institutions to determine which ones
     * we are deleting (in old but not in  new) and which ones
     * we are adding (in new but not in old)
     *
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
                    $id = is_numeric($inputInstitution)
                          ? $inputInstitution
                          : Institution::create(['name' => $inputInstitution]);
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
        return $this->belongsToMany('App\Institution', 'institution_users')
                    ->withTimestamps();
    }

    /**
     * Get the sigs associated with the given user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sigs()
    {
        return $this->belongsToMany('App\Sig', 'sig_users')
                    ->withPivot('main')->withTimestamps();
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
     * Get the disciplines associated with the given user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplines()
    {
        return $this->belongsToMany('App\Tag', 'user_tags')
                    ->where('tagtype_id', 1)
                    ->withTimestamps();
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
     * @return array
     */
    public function getTagIds()
    {
        return $this->tags->lists('id')->toArray();
    }

    /**
     * Get the list of institution ids associated with the user
     *
     * @return array
     */
    public function getInstitutionIds()
    {
        return $this->institutions->lists('id')->toArray();
    }

    /**
     * Determine if the user is allowed to edit the sig given by $sigId
     *
     * @param int $sigId
     * @return boolean
     */
    public function canEditSig($sigId)
    {
        return $this->isAdmin()
               || $this->isLeaderOfSig($sigId)
               || $this->isColeaderOfSig($sigId)
               || $this->isKeyPersonnelOfSig($sigId);
    }

    /**
     * Determine if the user can edit a sig AND is NOT an admin
     *
     * @param int $sigId
     * @return boolean
     */
    public function isSigEditor($sigId)
    {
        return $this->isLeaderOfSig($sigId) || $this->isColeaderOfSig($sigId);
    }

    /**
     * Determine if the user is a leader of the sig given by $sigId
     *
     * @param int $sigId
     * @return boolean
     */
    public function isLeaderOfSig($sigId)
    {
        return $this->sigs()->where('sigs.id', $sigId)
                            ->where('main', 1)->count() > 0;
    }

    /**
     * Determine if the user is a coleader of the sig given by $sigId
     *
     * @param int $sigId
     * @return boolean
     */
    public function isColeaderOfSig($sigId)
    {
        return $this->sigs()->where('sigs.id', $sigId)
                            ->where('main', 2)->count() > 0;
    }

    /**
     * Determine if the user is a key member of the sig given by $sigId
     *
     * @param int $sigId
     * @return boolean
     */
    public function isKeyPersonnelOfSig($sigId)
    {
        return $this->sigs()->where('sigs.id', $sigId)
                            ->where('main', 3)->count() > 0;
    }

    /**
     * Determine if the user is asscociated with the sig given by $sigId
     *
     * @param int $sigId
     * @return boolean
     */
    public function belongsToSig($sigId)
    {
        return $this->sigs()->where('sigs.id', $sigId)->count() > 0;
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->group_id === 1;
    }

    /**
     * Determine if the user is the leader of at least one sig.
     *
     * @return boolean
     */
    public function isSigLeader()
    {
        return $this->sigs()->where('main', 1)->count() > 0;
    }

    /**
     * Determine if the user is the co-leader of at least one sig.
     *
     * @return boolean
     */
    public function isSigCoLeader()
    {
        return $this->sigs()->where('main', 2)->count() > 0;
    }

    /**
     * Determine if the user is the key personnel of at least one sig.
     *
     * @return boolean
     */
    public function isSigKeyPersonnel()
    {
        return $this->sigs()->where('main', 3)->count() > 0;
    }

    /**
     * Determine if the user is the member of at least one sig.
     *
     * @return boolean
     */
    public function isSigMember()
    {
        return $this->sigs()->where('main', 0)->count() > 0;
    }

    /**
     * Get the SIG for which the user is a leader
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sigLeaderships()
    {
        return $this->sigs()->where('main', 1)->get();
    }

    /**
     * Get the IDs of the SIG for which the user is a leader
     *
     * @return array
     */
    public function sigLeadershipsIds()
    {
        return $this->sigs()->where('main', 1)->lists('id')->toArray();
    }

    /**
     * Get the value of the sig_users.main attribute for the user
     * and a given $sigId
     *
     * @param int $sigId
     * @return int
     */
    public function sigStatusId($sigId)
    {
        if (!$this->belongsToSig($sigId)) {
            return null;
        }
        return $this->sigs()->where('sigs.id', $sigId)->first()->pivot->main;
    }

    /**
     * Get the membership status of the user for a given $sigId
     *
     * @param int $sigId
     * @return string
     */
    public function sigStatus($sigId)
    {
        switch ($this->sigStatusId($sigId)) {
            case 0: return "Member";
            case 1: return "Leader";
            case 2: return "Co-leader";
            case 3: return "Key personnel";
        }
        return null;
    }
}

