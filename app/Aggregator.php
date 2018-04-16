<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Aggregator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'longname', 'realurl'
    ];

    /**
     * The booting method of the model.
     * It has been overwritten to exclude soft-deleted records from queries
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('deleted', function (Builder $builder) {
           $builder->where('aggregators.deleted', '=', '0'); 
        });
    }
}

