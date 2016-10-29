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
     * Find the id of a subscription given its id
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @static
     * @param string $email
     * @return array
     */
    public static function getId($email)
    {
        return DB::table('subscriptions')->where('email', $email)->pluck('id');
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
