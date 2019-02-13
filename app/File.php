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
        $is_video = $this->filetype->shortname === 'Video';
        if (!$is_video || (!$is_sms && !$is_vimeo)) {
            return "";
        }

        if ($is_sms) {
            $url = str_replace('/embed', '', $this->path);
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
        }
        return "";
    }
}
