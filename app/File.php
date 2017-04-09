<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class File extends Model
{
    /**
     * The booting method of the model. It has been overwritten to exclude soft-deleted records from queries
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @access protected
     * @static
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('deleted', function (Builder $builder) {
            $builder->where('files.deleted', '=', '0');
        });
    }
}
