<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Subscription extends Model
{

    use SoftDeletes;

    /**
     * Get all mailing list emails
     *
     * @return array
     */
    public static function getEmails()
    {
        return DB::table('subscriptions')
                   ->orderBy('created_at', 'DESC')
                   ->pluck('email');
    }

    /**
     * Find the id of a subscription given its email
     *
     * @param string $email
     * @return array
     */
    public static function getIdByEmail($email)
    {
        return DB::table('subscriptions')
                   ->where('email', $email)
                   ->pluck('id');
    }

    /**
     * Find the id of a subscription given its user id
     *
     * @param int $user_id
     * @return array
     */
    public static function getIdByUser($user_id)
    {
        return DB::table('subscriptions')
                   ->where('user_id', $user_id)
                   ->pluck('id');
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

