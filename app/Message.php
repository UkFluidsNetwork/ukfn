<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
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
        'body',
        'attachment',
        'user_id',
        'sent',
        'public',
        'mailinglist',
        'deleted'
    ];

    /**
     * Get all messages
     *
     * @return array
     */
    public static function getAll()
    {
        return DB::table('messages')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get all messages sent to the mailing list
     *
     * @return array
     */
    public static function getMailinglistMessages()
    {
        return DB::table('messages')->where('mailinglist', 1)
                  ->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get all public messages
     *
     * @return array
     */
    public static function getPublicMessages()
    {
        return DB::table('messages')
                  ->where(['public' => 1, 'mailinglist' => 0])
                  ->orderBy('created_at', 'DESC')->get();
    }
}

