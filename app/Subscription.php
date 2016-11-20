<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Subscription extends Model
{

    /**
     * Get all subscriptions
     * 
     * @access public
     * @static
     * @return array
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public static function getAll()
    {
        return DB::table('subscriptions')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Get all mailing list emails
     * 
     * @access public
     * @static
     * @return array
     * @author Javier Arias <ja573@cam.ac.uk>
     */
    public static function getEmails()
    {
        return DB::table('subscriptions')->orderBy('created_at', 'DESC')->pluck('email');
    }

    /**
     * Find the id of a subscription given its email
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @static
     * @param string $email
     * @return array
     */
    public static function getIdByEmail($email)
    {
        return DB::table('subscriptions')->where('email', $email)->pluck('id');
    }

    /**
     * Find the id of a subscription given its user id
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @static
     * @param int $user_id
     * @return array
     */
    public static function getIdByUser($user_id)
    {
        return DB::table('subscriptions')->where('user_id', $user_id)->pluck('id');
    }

    /**
     * Get all test mailing list emails
     * 
     * @access public
     * @static
     * @return array
     * @author Javier Arias <ja573@cam.ac.uk>
     */
    public static function getTestEmails()
    {
        return DB::table('testsubscriptions')->pluck('email');
    }

    /**
     * Get the user associated with the given subscription
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
