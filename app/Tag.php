<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    /**
     * Get all tags
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return array
     */
    public static function getAll()
    {
        return DB::table('tags')->get();
    }

    /**
     * Get all tags of type sub-disciplines
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return array
     */
    public static function getAllDisciplines()
    {
        $tagtype_id = self::findTagtypeByName('Sub-disciplines');
        return DB::table('tags')->where('tagtype_id', $tagtype_id)->get();
    }

    /**
     * Get all tags of type application areas
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return array
     */
    public static function getAllApplicationAreas()
    {
        $tagtype_id = self::findTagtypeByName('Application Area');
        return DB::table('tags')->where('tagtype_id', $tagtype_id)->get();
    }

    /**
     * Get all tags of type techniques
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return array
     */
    public static function getAllTechniques()
    {
        $tagtype_id = self::findTagtypeByName('Techniques');
        return DB::table('tags')->where('tagtype_id', $tagtype_id)->get();
    }

    /**
     * Get all tags of type facilities
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return array
     */
    public static function getAllFacilities()
    {
        $tagtype_id = self::findTagtypeByName('Facilities');
        return DB::table('tags')->where('tagtype_id', $tagtype_id)->get();
    }

    /**
     * Get the id of a tagtype given its name
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access private
     * @return int|null
     */
    private static function findTagtypeByName($name)
    {
        $tagtype = DB::table('tagtypes')->where('name', $name)->first();
        return $tagtype !== null ? (int) $tagtype->id : null;
    }
    
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
