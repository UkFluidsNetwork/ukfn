<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carouselfile extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'author', 'description', 'file_id'];

    /**
     * Get the files of the carousel
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function file()
    {
        return $this->belongsTo('App\File');
    }
}
