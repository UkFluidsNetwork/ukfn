<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tag extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'tagtype_id', 'category'
    ];
    
    /**
     * The booting method of the model. It has been overwritten to exclude soft-deleted records from queries
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access protected
     * @static
     */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('deleted', function (Builder $builder) {
           $builder->where('tags.deleted', '=', '0'); 
        });
    }

    /**
     * Get all tags
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @static
     * @return array
     */
    public static function getAll()
    {
        return DB::table('tags')->get();
    }

    /**
     * Get all tags that match a given tagtype_id
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access private
     * @static
     * @param int $tagtype_id
     * @return array
     */
    private static function getByTagtype($tagtype_id)
    {
        return DB::table('tags')->where('tagtype_id', $tagtype_id)->orderBy('category','ASC')->orderBy('name', 'ASC')->get();
    }

    /**
     * Get all tags that match a given tagtype name
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access private
     * @static
     * @param string $tagtype
     * @return array
     */    
    private static function getByTagtypeName($tagtype)
    {
        switch ($tagtype) {
            case "Sub-disciplines":
                $tagtype_id = self::findTagtypeByName('Sub-disciplines');
                break;
            case "Application Area":
                $tagtype_id = self::findTagtypeByName('Application Area');
                break;
            case "Techniques":
                $tagtype_id = self::findTagtypeByName('Techniques');
                break;
            case "Facilities":
                $tagtype_id = self::findTagtypeByName('Facilities');
                break;
            default:
                return null;
        }
        
        return self::getByTagtype($tagtype_id);
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
        return self::getByTagtypeName('Sub-disciplines');
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
        return self::getByTagtypeName('Application Area');
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
        return self::getByTagtypeName('Techniques');
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
        return self::getByTagtypeName('Facilities');
    }
    
    /**
     * Get all tag categories of type sub-disciplines
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return array
     */
    public static function getAllDisciplinesCategories()
    {
        $categories = [];
        $curCategory = "";
        $disciplines = self::getByTagtypeName('Sub-disciplines');
        foreach ($disciplines as $discipline) {
            if ($curCategory !== $discipline->category) {
                $categories[] = ["category" => $discipline->category];
                $curCategory = $discipline->category;
            }
        }
        return $categories;
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

    /**
     * Get the users associated with this tag
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_tags');
    }

    /**
     * Get the institutions associated with this tag
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function institutions()
    {
        return $this->belongsToMany('App\Institution', 'institution_tags');
    }

    /**
     * Get the tagtype of this tag
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagtype()
    {
        return $this->belongsTo('App\Tagtype', 'tagtype_id');
    }


    /**
     * Get the list of user ids associated with the tag
     * 
     * @access public
     * @return array
     */
    public function getUserIds()
    {
        return $this->users->lists('id')->toArray();
    }
    
    /**
     * Get the sigs associated with this tag
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sigs()
    {
        return $this->belongsToMany('App\Sig', 'sig_tags');
    }
}
