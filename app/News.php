<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class News extends Model
{

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'link'];

    /**
     * Get all news
     *
     * @param string $orderBy Attribute to order by
     * @param string $direction OrderBy direction
     * @param integer $limit Limit results
     * @return array
     */
    public static function getNews($orderBy = "created_at", $direction = "desc", $limit = null)
    {
        return DB::table('news')
                ->orderBy($orderBy, $direction)
                ->take($limit)
                ->get();
    }
}

