<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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
     * @return array
     * @static
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function getAll()
    {
        $messagesList = DB::table('messages')->orderBy('created_at', 'DESC')->get();

        return $messagesList;
    }

    /**
     * Get all messages sent to the mailing list
     * @author Javier Arias <ja573@cam.ac.uk>
     * @static
     * @access public
     * @return array
     */
    public static function getMailinglistMessages()
    {
        return DB::table('messages')->where('mailinglist', 1)->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get all public messages
     * @author Javier Arias <ja573@cam.ac.uk>
     * @static
     * @access public
     * @return array
     */
    public static function getPublicMessages()
    {
        return DB::table('messages')->where('public', 1)->orderBy('created_at', 'DESC')->get();
    }
}
