<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    /**
     * Needed so that laravel knows that this table does not have created_at nor updated_at fields
     * @access public
     * @var boolean
     */
    public $timestamps = false;

}
