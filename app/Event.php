<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Event extends Model
{

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['title', 'subtitle', 'description', 'start', 'end'];

    /**
     * Get all events
     *
     * @param string $orderBy Attribute to order by
     * @param string $direction OrderBy direction
     * @param integer $limit Limit results
     * @return array
     */
    public static function getEvents($orderBy = "start", $direction = "desc", $where = [], $limit = null)
    {
        return DB::table('events')
                ->where($where)
                ->orderBy($orderBy, $direction)
                ->take($limit)
                ->get();
    }
}

