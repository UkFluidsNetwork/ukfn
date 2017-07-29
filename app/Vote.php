<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Vote extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'competitionentry_id'];

    /**
     * Get the competition entry this vote is for
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function title()
    {
        return $this->belongsTo('App\Competitionentry');
    }
}

