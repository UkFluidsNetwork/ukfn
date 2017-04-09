<?php

namespace App\Http\Controllers;

use SEO;
use App\Resource;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{

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
            ? json_decode($parameters['types']) 
            : null;
        $disciplines = isset($parameters['search'])&& $parameters['search'] !== "[]" 
            ? json_decode($parameters['search']) 
            : null;
        
        $resources = [];
        $allResources = Resource::getByTypeAndDiscipline($types, $disciplines);
        foreach ($allResources as $resource) {
            $resource->tutorials();
            foreach ($resource->tutorials as $key => $tutorial) {
                $resource->tutorials[$key]->files = $tutorial->files();
                foreach ($resource->tutorials[$key]->files as $index => $file) {
                    $resource->tutorials[$key]->files[$index] = $file->filetype();
                }
                if (!empty($resource->tutorials[$key]->files)) {
                    $resources[] = $resource;
                }
            }
        }

        return response()->json($resources);
    }
}
