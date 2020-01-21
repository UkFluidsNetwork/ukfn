<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ecmember extends Model
{

    public $primaryKey = "user_id";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_id', 'role'];

    /**
     * Get the user associated with a given ec member
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the photo associated with a given ec member
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File');
    }
}
