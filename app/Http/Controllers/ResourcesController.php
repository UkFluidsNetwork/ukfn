<?php

namespace App\Http\Controllers;

use SEO;
use App\Tag;
use App\File;
use App\Resource;
use App\Tutorial;
use App\Filetype;
use Illuminate\Http\Request;
use App\Http\Requests\ResourceFormRequest;
use App\Http\Requests\TutorialFormRequest;
use App\Http\Requests\TutorialFileFormRequest;
use Illuminate\Support\Facades\Session;

class ResourcesController extends Controller
{

    private static $resourcesPanelCrumbs = [
        ['label' => 'Panel', 'path' => '/panel'],
        ['label' => 'Researcher Resources', 'path' => '/panel/resources']
    ];

    /**
     * index method
     *
     * @return view
     */
    public function index()
    {
        $pageDescription = "This section contains courses, tutorials, hints, tips and snippets of software, aimed at academic and industrial researchers in fluid mechanics.";
        SEO::setTitle('Researcher resources');
        SEO::setDescription($pageDescription);

        $resources = [];

        return view('resources.index', compact('resources', 'pageDescription'));
    }

    /**
     * Get all resources, its tutorials, and its files, in JSON format.
     * Only those resources that have tutorials with files are included.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllJson(Request $request)
    {
        $parameters = $request->all();
        $types = isset($parameters['types']) && $parameters['types'] !== "[]"
            ? (array) json_decode($parameters['types'])
            : null;
        $disciplines = isset($parameters['search'])&& $parameters['search'] !== "[]"
            ? (array) json_decode($parameters['search'])
            : null;

        $resources = [];
        $count = 0;
        $allResources = Resource::where('active', 1)->orderBy('order')->get();
        foreach ($allResources as $resource) {
            $toAdd = false;
            $resource->tutorials = $resource
                ->tutorials()->where('active', 1)->get();
            $fileTypes = [];
            foreach ($resource->tutorials as $key => $tutorial) {
                $resource->tutorials[$key]->files = $tutorial->files;
                foreach ($resource->tutorials[$key]->files as $index => $file) {
                    $file->filetype;
                    if (!in_array($file->filetype->shortname, $fileTypes)) {
                        $fileTypes[] = $file->filetype->shortname;
                    }
                    $resource->tutorials[$key]->files[$index] = $file;
                }
                // only add resources that have at least one file
                if ($resource->tutorials[$key]->files->count() > 0 && !$toAdd) {
                    $toAdd = true;
                }
            }
            // determine if types in filter match those in the resource
            foreach ($fileTypes as $type) {
                if ($types[$type] === true) {
                    $toAdd = true;
                    break;
                } else {
                    $toAdd = false;
                }
            }

            $tagFound = true;
            if (!empty($disciplines)) {
                $tagFound = false;
                foreach ($resource->tags as $tag) {
                    if (in_array($tag->id, $disciplines)) {
                        $tagFound = true;
                        break;
                    }
                }
            }
            if ($toAdd && $tagFound) {
                $resources[$count] = $resource;
                $resources[$count]['types'] = $fileTypes;
                $count++;
            }
        }
        return response()->json($resources);
    }

    public function view()
    {
        $bread = static::$resourcesPanelCrumbs;
        $breadCount = count($bread);

        $resources = Resource::orderBy('order')->get();
        foreach ($resources as $resource) {
            $resource->created = date("d M H:i",
                strtotime($resource->created_at));
            $resource->updated = date("d M H:i",
                strtotime($resource->updated_at));
        }
        return view('panel.resources.view',
            compact('resources', 'bread', 'breadCount'));
    }

    public function viewTutorials($resource_id)
    {
        $resource = Resource::findOrFail($resource_id);

        $bread = array_merge(static::$resourcesPanelCrumbs,
                             [['label' => $resource->name,
                               'path' => "/panel/resources/"]]);
        $breadCount = count($bread);

        foreach ($resource->tutorials as $tutorial) {
            $tutorial->created = date("d M H:i",
                strtotime($tutorial->created_at));
            $tutorial->updated = date("d M H:i",
                strtotime($tutorial->updated_at));
        }
        return view('panel.resources.viewtutorials',
            compact('resource', 'bread', 'breadCount'));
    }

    public function tutorialFiles($id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $resource = Resource::findOrFail($tutorial->resource_id);

        $bread = array_merge(static::$resourcesPanelCrumbs,
            [['label' => $resource->name,
              'path' => "/panel/resources/tutorials/" . $resource->id],
             ['label' => $tutorial->name,
              'path' => "/panel/resources/tutorials/edit/" . $tutorial->id],
             ['label' => "Files",
              'path' => "/panel/resources/tutorials/files/" . $tutorial->id]]);
        $breadCount = count($bread);

        foreach ($tutorial->files as $file) {
            $file->created = date("d M H:i",
                strtotime($tutorial->created_at));
            $file->full_path = url($file->path . "/" . $file->name);
        }
        return view('panel.resources.viewfiles',
            compact('tutorial', 'bread', 'breadCount'));
    }

    public function add()
    {
        $bread = array_merge(static::$resourcesPanelCrumbs,
                             [['label' => 'Add',
                               'path' => "/panel/resources/add"]]);
        $breadCount = count($bread);

        $resource = new Resource;
        $resourceTags = [];
        $subDisciplines = Tag::getAllDisciplines();
        $curDisciplinesCategory = null;

        return view('panel.resources.add',
                    compact('resource', 'resourceTags', 'subDisciplines',
                            'curDisciplinesCategory', 'bread', 'breadCount'));
    }

    public function edit($id)
    {
        $resource = Resource::findOrFail($id);
        $bread = array_merge(static::$resourcesPanelCrumbs,
                                [['label' => 'Edit',
                                  'path' => "/panel/resources/edit/${id}"]]);

        $breadCount = count($bread);
        $resourceTags = $resource->getTagIds();
        $subDisciplines = Tag::getAllDisciplines();
        $curDisciplinesCategory = null;

        return view('panel.resources.edit',
                    compact('resource', 'resourceTags', 'subDisciplines',
                            'curDisciplinesCategory', 'bread', 'breadCount'));
    }

    public function addTutorial($resource_id)
    {
        $tutorial = new Tutorial;
        $resource = Resource::findOrFail($resource_id);
        $bread = array_merge(static::$resourcesPanelCrumbs,
            [['label' => $resource->name,
              'path' => "/panel/resources/edit/" . $resource->id],
             ['label' => "Add Tutorial",
              'path' => "/panel/resources/tutorials/add/"]
                  ]);

        $breadCount = count($bread);

        return view('panel.resources.addtutorial',
                    compact('tutorial', 'resource', 'bread', 'breadCount'));
    }

    public function addFile($tutorial_id)
    {
        $tutorial = Tutorial::findOrFail($tutorial_id);
        $resource = Resource::findOrFail($tutorial->resource_id);
        $files = File::whereNull("tutorial_id")->get();
        $filetypes = Filetype::all();

        $bread = array_merge(static::$resourcesPanelCrumbs,
        [['label' => $resource->name,
          'path' => "/panel/resources/tutorials/" . $resource->id],
         ['label' => $tutorial->name,
          'path' => "/panel/resources/tutorials/edit/" . $tutorial->id],
         ['label' => "Files",
          'path' => "/panel/resources/tutorials/files/" . $tutorial->id],
         ['label' => "Add Files",
          'path' => "/panel/resources/tutorials/files/add/" . $tutorial->id]]);
        $breadCount = count($bread);

        return view('panel.resources.addfile',
                    compact('tutorial', 'files', 'filetypes',
                            'bread', 'breadCount'));
    }

    public function editTutorial($id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $resource = Resource::findOrFail($tutorial->resource_id);
        $bread = array_merge(static::$resourcesPanelCrumbs,
            [['label' => $resource->name,
              'path' => "/panel/resources/tutorials/" . $resource->id],
             ['label' => $tutorial->name,
              'path' => "/panel/resources/tutorials/edit/" . $tutorial->id]
                  ]);

        $breadCount = count($bread);

        return view('panel.resources.edittutorial',
                    compact('tutorial', 'resource', 'bread', 'breadCount'));
    }

    /**
     * Create resources
     *
     * @param TutorialFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function createTutorial(TutorialFormRequest $request)
    {
        try {
            $tutorial = new Tutorial;
            $input = $request->all();
            $tutorial->fill($input);
            $tutorial->save();

            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/resources/tutorials/'.$input['resource_id']);
    }

    /**
     * Update resources
     *
     * @param int $id
     * @param TutorialFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function updateTutorial($id, TutorialFormRequest $request)
    {
        $tutorial = Tutorial::findOrFail($id);

        try {
            $input = $request->all();
            $input['date'] = $input['date'] . "-01-01";
            $tutorial->fill($input);
            $tutorial->save();

            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }

        return redirect('/panel/resources/tutorials/' . $tutorial->resource_id);
    }

    /**
     * Update resources
     *
     * @param int $tutorial_id
     * @param TutorialFileFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function addTutorialFile($tutorial_id, TutorialFileFormRequest $request)
    {
        $tutorial = Tutorial::findOrFail($tutorial_id);
        $file = File::findOrFail($request->file_id);
        $filetype = Filetype::findOrFail($request->filetype_id);

        try {
            $file->tutorial_id = $tutorial->id;
            $file->filetype_id = $filetype->id;
            $file->save();

            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }

        return redirect('/panel/resources/tutorials/files/' . $tutorial->id);
    }

    /**
     * Create resources
     *
     * @param ResourceFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function create(ResourceFormRequest $request)
    {
        try {
            $resource = new Resource;
            $input = $request->all();
            $resource->fill($input);
            $resource->save();

            $resource->updateTags($request->toArray());
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/resources');
    }

    /**
     * Update resources
     *
     * @param int $id
     * @param ResouceFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function update($id, ResourceFormRequest $request)
    {
        $resource = Resource::findOrFail($id);

        try {
            $input = $request->all();
            $resource->fill($input);
            $resource->save();

            $resource->updateTags($request->toArray());
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }

        return redirect('/panel/resources');
    }

    /**
     * Delete a resource and its associated tutorials
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function delete($id)
    {
        try {
            $resource = Resource::findOrFail($id);
            foreach ($resource->tutorials as $tutorial) {
                $tutorial->delete();
            }
            $resource->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/resources/');
    }

    /**
     * Delete a tutorial
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function deleteTutorial($id)
    {
        try {
            $tutorial = Tutorial::findOrFail($id);
            $tutorial->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/resources/tutorials/' . $tutorial->resource_id);
    }

    /**
     * Unlink a file from its tutorial
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function deleteFile($id)
    {
        try {
            $file = File::findOrFail($id);
            $tutorial_id = $file->tutorial_id;
            $file->tutorial_id = null;
            $file->save();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/resources/tutorials/files/'
            . $tutorial_id);
    }

    /**
     * Enable/disable a course
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function toggleResourceStatus($id)
    {
        try {
            $resource = Resource::findOrFail($id);
            if ($resource->status() === "Enabled") {
                $resource->active = 0;
            } else {
                $resource->active = 1;
            }
            $resource->save();
            Session::flash('success_message', $resource->status()
                                              . ' succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/resources/');
    }

    /**
     * Enable/disable a tutorial
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function toggleTutorialStatus($id)
    {
        try {
            $tutorial = Tutorial::findOrFail($id);
            if ($tutorial->status() === "Enabled") {
                $tutorial->active = 0;
            } else {
                $tutorial->active = 1;
            }
            $tutorial->save();
            Session::flash('success_message', $tutorial->status()
                                              . ' succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/resources/tutorials/' . $tutorial->resource_id);
    }

    /**
     * Change the order of a resource
     *
     * @param string $direction up/down
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function moveResource($direction, $id)
    {
        try {
            $resource = Resource::findOrFail($id);
            if ($direction === "up") {
                $resource->order--;
            } else {
                $resource->order++;
            }
            $resource->save();
            Session::flash('success_message', 'Moved succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/resources/');
    }

    /**
     * Change the order of a tutorial
     *
     * @param string $direction up/down
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function moveTutorial($direction, $id)
    {
        try {
            $tutorial = Tutorial::findOrFail($id);
            if ($direction === "up") {
                $tutorial->priority--;
            } else {
                $tutorial->priority++;
            }
            $tutorial->save();
            Session::flash('success_message', 'Moved succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/resources/tutorials/' . $tutorial->resource_id);
    }
}
