<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sentmessage extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from',
        'to',
        'subject',
        'template',
        'parameters',
        'attachment',
        'sent'
    ];

}
