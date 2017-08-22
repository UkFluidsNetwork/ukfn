<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Vote extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'competitionentry_id'];

    /**
     * Get the competition entry this vote is for
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function entry()
    {
        return $this->belongsTo('App\Competitionentry');
    }

    /**
     * Check if the vote is valid
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->isUnique();
    }

    /**
     * Check if the tuple [email, filetype] is unique
     *
     * @return bool
     */
    public function isUnique()
    {
        $entry = Competitionentry::findOrFail($this->competitionentry_id);
        $filetype_id = $entry->file->filetype->id;

        $existing = DB::table('votes')
                 ->join('competitionentries', 'votes.competitionentry_id',
                          '=', 'competitionentries.id')
                 ->join('files', 'files.id', '=', 'competitionentries.file_id')
                 ->join('filetypes', 'files.filetype_id', '=', 'filetypes.id')
                 ->where('email', $this->email)
                 ->where('filetypes.id', $filetype_id)
                 ->count();
        return $existing <= 0; // check if unique tuple [email,filetype];
    }
}

