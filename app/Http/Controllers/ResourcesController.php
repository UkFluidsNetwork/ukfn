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
            ? (array) json_decode($parameters['types'])
            : null;
        $disciplines = isset($parameters['search'])&& $parameters['search'] !== "[]"
            ? (array) json_decode($parameters['search'])
            : null;

        $resources = [];
        $count = 0;
        $allResources = Resource::all();
        foreach ($allResources as $resource) {
            $toAdd = false;
            $resource->tutorials;
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
}
