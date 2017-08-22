<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Sig extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'shortname', 'description', 'bigimage', 'smallimage',
        'twitterurl'
    ];

    /**
     * List of valid statuses for a member (member, leader, co-leader,
     * key personnel).
     * @var array
     */
    private static $validMembershipStatus = [0, 1, 2, 3];

    /**
     * The booting method of the model. It has been overwritten to exclude
     * soft-deleted records from queries
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('deleted', function (Builder $builder) {
            $builder->where('sigs.deleted', '=', '0');
        });
    }

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
     * Compare old and new institutions to determine which ones we are
     * deleting (in old but not in  new) and which ones we are adding
     * (in new but not in old)
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
     * Find a SIG given its short name
     *
     * @param string $slug
     * @return array
     */
    public static function findBySlug($slug)
    {
        return DB::table('sigs')
                ->where('shortname', 'like', "%${slug}%")
                ->get();
    }

    /**
     * Get the users associated with the given sig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'sig_users')
                    ->withTimestamps()->withPivot('main');
    }

    /**
     * Get the institution associated with the given sig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function institutions()
    {
        return $this->belongsToMany('App\Institution', 'sig_institutions')
                    ->withTimestamps()->withPivot('main');
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

    /**
     * Get the list of tag ids associated with the sig
     *
     * @return array
     */
    public function getTagIds()
    {
        return $this->tags->lists('id')->toArray();
    }

    /**
     * Get the list of institution ids associated with the sig
     *
     * @return array
     */
    public function getInstitutionIds()
    {
        return $this->institutions->lists('id')->toArray();
    }

    /**
     * Get the main institution of this sig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function mainInstitution()
    {
        return $this->belongsToMany('App\Institution', 'sig_institutions')
                    ->wherePivot('main', 1);
    }

    /**
     * Get the main institution of this sig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function secondaryInstitutions()
    {
        return $this->belongsToMany('App\Institution', 'sig_institutions')
                    ->wherePivot('main', 2);
    }

    /**
     * Get the boxes of this sig
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function boxes()
    {
        return $this->hasMany('App\Sigbox')->orderBy('order');
    }

    /**
     * Get the boxes of this sig
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function activeBoxes()
    {
        return $this->hasMany('App\Sigbox')->where('active', 1)->orderBy('order');
    }

    /**
     * Get the id of the main institution associated with the sig
     *
     * @return array
     */
    public function getMainInstitutionId()
    {
        return $this->mainInstitution->lists('id')->toArray();
    }

    /**
     * Get the id of the secondary institutions associated with the sig
     *
     * @return array
     */
    public function getSecondaryInstitutionIds()
    {
        return $this->secondaryInstitutions->lists('id')->toArray();
    }

    /**
     * Get the leader (main user) of this sig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function leader()
    {
        return $this->belongsToMany('App\User', 'sig_users')
                    ->wherePivot('main', 1);
    }

    /**
     * Get the co-leaders of this sig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coleaders()
    {
        return $this->belongsToMany('App\User', 'sig_users')
                    ->wherePivot('main', 2);
    }

    /**
     * Get the key personnel of this sig
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function personnel()
    {
        return $this->belongsToMany('App\User', 'sig_users')
                    ->wherePivot('main', 3);
    }

    /**
     * Get the id of the user who is the leader of the SIG
     *
     * @return array
     */
    public function getLeaderId()
    {
        return $this->leader->lists('id')->toArray();
    }

    /**
     * Get the ids of the users who are co-leaders of the SIG
     *
     * @return array
     */
    public function getColeaderIds()
    {
        return $this->coleaders->lists('id')->toArray();
    }

    /**
     * Get the subscriptions associated with this sig
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }

    /**
     * Find whether a given status is allowed as a type of member
     *
     * @param int $status
     * @return boolean
     */
    public static function isStatusValid($status)
    {
        return in_array($status, static::$validMembershipStatus);
    }
}

