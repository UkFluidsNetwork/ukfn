<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagsFormRequest;
use Illuminate\Support\Facades\Session;
use Auth;
use Cache;
use Carbon\Carbon;
use App\Tag;
use App\Tagtype;

class TagsController extends Controller
{

    /**
     * Default breadcrumbs for /panel/tags
     *
     * @var array
     */
    private static $crumbs = [
        ['label' => 'Panel', 'path' => '/panel'],
        ['label' => 'Tags', 'path' => '/panel/tags']
    ];

    /**
     * List all tags
     *
     * @return Illuminate\Support\Facades\View
     */
    public function view($show = 'all')
    {
        $bread = static::$crumbs;
        $breadCount = count($bread);

        switch ($show) {
            case "all":
                $tags = Tag::all();
                $tagtype = "All";
                break;
            case "disciplines":
                $tags = Tag::getAllDisciplines();
                $tagtype = "Fluids sub-disciplines";
                break;
            case "applications":
                $tags = Tag::getAllApplicationAreas();
                $tagtype = "Application areas";
                break;
            case "techniques":
                $tags = Tag::getAllTechniques();
                $tagtype = "Techniques";
                break;
            case "facilities":
                $tags = Tag::getAllFacilities();
                $tagtype = "Facilities";
                break;
        }

        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $tag->created = PagesController::formatDate($tag->created_at);
                $tag->updated = PagesController::formatDate($tag->updated_at);
            }
        }

        return view('panel.tags.view',
                    compact('tags', 'bread', 'breadCount', 'tagtype'));
    }

    /**
     * Edit tags
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $crumb =  [['label' => 'Edit', 'path' => '/panel/tags/edit']];
        $bread = array_merge(static::$crumbs, $crumb);
        $breadCount = count($bread);

        $tag = Tag::findOrFail($id);
        $tagtypes = Tagtype::lists('name', 'id');

        return view('panel.tags.edit',
                    compact('tag', 'bread', 'breadCount', 'tagtypes'));
    }

    /**
     * Update tags
     *
     * @param int $id
     * @param TagsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function update($id, TagsFormRequest $request)
    {
        try {
            $tag = Tag::findOrFail($id);
            $input = $request->all();
            $tag->fill($input);
            $tag->save();
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/tags');
    }

    /**
     * Add tags
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
        $crumb =  [['label' => 'Edit', 'path' => '/panel/tags/add']];
        $bread = array_merge(static::$crumbs, $crumb);
        $breadCount = count($bread);

        $tagtypes = Tagtype::lists('name', 'id');

        return view('panel.tags.add',
                    compact('bread', 'breadCount', 'tagtypes'));
    }

    /**
     * Create tags
     *
     * @param TagsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function create(TagsFormRequest $request)
    {
        try {
            $tag = new Tag;
            $input = $request->all();
            $tag->fill($input);
            $tag->save();
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/tags');
    }

    /**
     * Delete tags
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function delete($id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->users()->detach($tag->getUserIds());
            $tag->deleted = 1;
            $tag->save();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/tags');
    }

    /**
     * Get all resources tags given a type.
     *
     * @param string $tagtype
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public static function getAllJson($tagtype)
    {
        // see if request has been cached
        if (Cache::has('tags-'.$tagtype)) {
            return response()->json(Cache::get('tags-'.$tagtype));
        }

        $tags = [];
        switch ($tagtype) {
            case "all":
                $rawTags = Tag::all();
                break;
            case "disciplines":
                $rawTags = Tag::getAllDisciplines();
                break;
            case "applications":
                $rawTags = Tag::getAllApplicationAreas();
                break;
            case "techniques":
                $rawTags = Tag::getAllTechniques();
                break;
            case "facilities":
                $rawTags = Tag::getAllFacilities();
                break;
        }
        foreach ($rawTags as $tag) {
            $tags[$tag->id] = $tag;
            $type = Tagtype::findOrFail($tag->tagtype_id);
            $tags[$tag->id]->tagtype = $type;
        }

        $expiresAt = Carbon::now()->addDay(1);
        Cache::put('tags-'.$tagtype, $tags, $expiresAt);
        return response()->json($tags);
    }

    /**
     * Get all categories of tags belonging to a given tagtype
     *
     * @todo Implement the rest of the cases: applications, techniques, etc.
     * @param string $tagtype
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public static function getAllCategoriesJson($tagtype)
    {
        $categories = [];
        switch ($tagtype) {
            case "disciplines":
                $categories = Tag::getAllDisciplinesCategories();
                break;
        }
        return response()->json($categories);
    }
}
