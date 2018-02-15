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
        return $this->belongsToMany('App\Tag', 'resource_tags')
                    ->withTimestamps();
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
     * Get the list of tag ids associated with the resource
     *
     * @return array
     */
    public function getTagIds()
    {
        return $this->tags->lists('id')->toArray();
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
}
