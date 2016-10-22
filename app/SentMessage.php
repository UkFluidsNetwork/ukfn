<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SentMessage extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'to',
        'message_id',
        'sent'
    ];

}
