<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Sig_users extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'main', 'sig_id', 'user_id'
    ];

    /**
     * The booting method of the model. It has been overwritten to exclude soft-deleted records from queries
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access protected
     * @static
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('deleted', function (Builder $builder) {
            $builder->where('sig_users.deleted', '=', '0');
        });
    }

    
}
