<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'type', 'gallery', 'description', 'title', 'author'
    ];

    /**
     * Get the tutorial that this file belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turorial()
    {
        return $this->belongsTo('App\Tutorial');
    }

    /**
     * Get the sig that this file belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sig()
    {
        return $this->belongsTo('App\Sig');
    }

    /**
     * Get the type of this file
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function filetype()
    {
        return $this->belongsTo('App\Filetype');
    }

    /**
     * Get the user that uploaded this file
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * Get the competitionentries associated with this file
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function competitionentries()
    {
        return $this->hasMany('App\Competitionentry');
    }


    /**
     * Get the tags associated with this file
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'file_tags')
                    ->withTimestamps();
    }

    /**
     * Get the youtube id
     *
     * @return String
     */
    public function getYoutubeId()
    {
        $is_youtube = strpos($this->path, "youtube.com");
        if (!$is_youtube) {
            return "";
        }
        $url = parse_url($this->path);
        if (isset($url['query'])) {
            parse_str($url['query'], $query);
            if (isset($query['v'])) {
                return $query['v'];
            }
        }
        return "";
    }

    /**
     * Get the media URL of an sms.cam.ac.uk video
     *
     * @return String
     */
    public function getSmsMediaUrl()
    {
        $is_sms = strpos($this->path, "sms.cam.ac.uk");
        $is_download = strpos($this->path, "https://downloads.sms.cam.ac.uk");
        if (!$is_sms) {
            return "";
        }
        $url = parse_url($this->path);
        if ($is_download) {
            $id = explode('/', $url['path'])[1];
            $media_url = "https://sms.cam.ac.uk/media/${id}";
        } else {
            $media_url = str_replace('/embed', '', $this->path);
        }
        return $media_url;
    }

    /**
     * Attempt to get a thumbnail from sms or vimeo if file is a video
     *
     * @return String
     */
    public function getThumbnail()
    {
        $cache_key = 'thumb-'.$this->id;
        if (Cache::has($cache_key)) {
          return Cache::get($cache_key);
        }
        // we only support sms and vimeo
        $is_sms = strpos($this->path, "sms.cam.ac.uk");
        $is_vimeo = strpos($this->path, "vimeo.com");
        $is_youtube = strpos($this->path, "youtube.com");
        $is_video = is_null($this->type) || $this->filetype->shortname === 'Video';
        if (!$is_video || (!$is_sms && !$is_vimeo && !$is_youtube)) {
            return "";
        }

        if ($is_sms) {
            $url = $this->getSmsMediaUrl();
            $api = "https://sms.cam.ac.uk/oembed?url=" . urlencode($url)
                   . "&format=json";
            $json = json_decode(file_get_contents($api));
            if (isset($json->thumbnail_url)) {
                $thumb = $json->thumbnail_url;
                Cache::forever($cache_key, $thumb);
                return $thumb;
            }
        } elseif ($is_vimeo) {
            $url = explode('/', $this->path);
            $id = $url[sizeof($url)-1];
            $api = "http://vimeo.com/api/v2/video/${id}.json";
            $json = json_decode(file_get_contents($api));
            if (isset($json[0]->thumbnail_medium)) {
                $thumb = $json[0]->thumbnail_medium;
                Cache::forever($cache_key, $thumb);
                return $thumb;
            }
        } elseif ($is_youtube) {
            $url = parse_url($this->path);
            if (isset($url['query'])) {
                parse_str($url['query'], $query);
                if (isset($query['v'])) {
                    $id = $query['v'];
                    $thumb = "https://img.youtube.com/vi/${id}/hqdefault.jpg";
                    Cache::forever($cache_key, $thumb);
                    return $thumb;
                }
            }
        }
        return "";
    }

    /**
     * Get the list of tag ids associated with the file
     *
     * @return array
     */
    public function getTagIds()
    {
        return $this->tags->lists('id')->toArray();
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
                     'techniques' => 3, 'facilities' => 4, 'multimedia' => 5];

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
