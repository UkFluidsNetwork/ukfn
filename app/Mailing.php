<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mailing extends Model
{

    /**
     * Add email address to messages table 
     * 
     * @static
     * @access public
     * @param string $email Subscription email taken from form
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function addEmail($email)
    {
        // check if existing email exists
        $existingEmail = DB::table('subscriptions')->where('email', '=', $email)->get();

        if (empty($existingEmail)) {
            $subscription = new Subscription();
            $subscription->email = $email;
            $subscription->save();
        }
    }

    /**
     * Get all mailing list emails
     * 
     * @access public
     * @static
     * @return array
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function getAll()
    {
        $mailingList = DB::table('subscriptions')->orderBy('created_at', 'DESC')->get();

        return $mailingList;
    }
}
