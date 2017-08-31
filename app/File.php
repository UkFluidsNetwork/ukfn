<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * Get the tutorial that this file belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turorial()
    {
        return $this->belongsTo('App\Tutorial');
    }

    /**
     * Get the sig that this file belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function filesl()
    {
        return $this->belongsTo('App\Sig');
    }

    /**
     * Get the type of this file
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function filetype()
    {
        return $this->belongsTo('App\Filetype');
    }

    /**
     * Get the user that uploaded this file
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
