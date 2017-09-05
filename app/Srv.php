<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Srv extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['institution_id', 'description', 'name',
          'visitor', 'user_id', 'department', 'visiting', 'reporturl'];

    /**
     * Get the visitor user_id if it has one
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the institution of the visitor
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function institution()
    {
        return $this->belongsTo('App\Institution');
    }
}

