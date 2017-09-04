<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Competitionentry extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'file_id', 'user_id'];

    /**
     * Get the file uploaded for this entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File');
    }

    /**
     * Get the user who uploaded this entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the institution the contestant is member of
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function institution()
    {
        return $this->belongsTo('App\Institution');
    }

    /**
     * Get the votes this entry has received
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    /**
     * Get the votes this entry has received
     *
     * @return array
     */
    public static function winnersIds()
    {
        return DB::table('competitionentries')->where('winner', '=', 1)->get();
    }
}

