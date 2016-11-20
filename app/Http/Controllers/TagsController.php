<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagsFormRequest;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Tag;
use App\Tagtype;

class TagsController extends Controller
{

    /**
     * List all tags
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return void
     */
    public function view($show = 'all')
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Tags', 'path' => '/tags']
        ];
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
                $tag->created = date("d M H:i", strtotime($tag->created_at));
                $tag->updated = date("d M H:i", strtotime($tag->updated_at));
            }
        }

        return view('panel.tags.view', compact('tags', 'bread', 'breadCount', 'tagtype'));
    }

    /**
     * Edit tags
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Tags', 'path' => '/tags'],
            ['label' => 'Edit', 'path' => '/tags/edit'],
        ];
        $breadCount = count($bread);

        $tag = Tag::findOrFail($id);
        $tagtypes = Tagtype::lists('name', 'id');

        return view('panel.tags.edit', compact('tag', 'bread', 'breadCount', 'tagtypes'));
    }

    /**
     * Update tags
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @param TagsFormRequest $request
     * @return void
     */
    public function update($id, TagsFormRequest $request)
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }
        
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
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function add()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Tags', 'path' => '/tags'],
            ['label' => 'Add', 'path' => '/tags/add'],
        ];
        $breadCount = count($bread);

        $tagtypes = Tagtype::lists('name', 'id');
        
        return view('panel.tags.add', compact('bread', 'breadCount', 'tagtypes'));
    }

    /**
     * Create tags
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param TagsFormRequest $request
     * @return void
     */
    public function create(TagsFormRequest $request)
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }
        
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
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }
        
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
}
