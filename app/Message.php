<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Message extends Model
{
    /**
     * Get all messages
     * 
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
     * Add new message
     * 
     * @param string $from
     * @param string $subject
     * @param string $body
     * @param intiger $userID
     * @param boolean $public
     * @param boolean $mailing
     * @param string $toEmailRaw
     * @static
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function addNew($from, $subject, $body, $userID, $public, $mailing, $toEmailRaw)
    {
        $m = new Message();
        $m->from        = $from;
        $m->subject     = $subject;
        $m->body        = $body;
        $m->user_id     = $userID;
        $m->public      = $public;
        $m->mailingList = $mailing;
        $m->to          = $toEmailRaw;
        $m->save();
    }
}
