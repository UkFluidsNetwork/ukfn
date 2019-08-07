<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\File;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\FileFormRequest;
use App\Http\Requests\FileUploadRequest;

class FilesController extends Controller
{

    private static $filePanelCrumbs = [
        ['label' => 'Panel', 'path' => '/panel'],
        ['label' => 'Files', 'path' => '/panel/files']
    ];

    /**
     * Mapping of storage disks and their real path as specified
     * in /config/filesystems; sadly these cannot be retrieved
     * programmatically and need to be hardcoded.
     *
     * @var array
     */
    public static $disks = [
        "public-files" => "/files",
        "attachments" => "/files/attachments",
        "sig-pictures" => "/pictures/sig",
        "resources" => "/files/resources",
        "meetings" => "/files/meetings",
        "srv" => "/files/srv",
        "sig" => "/files/sig"
    ];

    /**
     * List all files
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index()
    {
        $bread = static::$filePanelCrumbs;
        $breadCount = count($bread);

        $thisServer = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

        $files = File::all()->sortByDesc("created_at");
        foreach ($files as $file) {
            $file->created = PagesController::formatDate($file->created_at);
            $file->updated = PagesController::formatDate($file->updated_at);
            $file->full_path = $file->path !== $file->name
                ? url($file->path . "/" . $file->name)
                : url($file->path);
        }

        return view('panel.files.index',
                    compact('bread', 'breadCount', 'files'));
    }

    /**
     * Add new file view
     *
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Files', 'path' => '/panel/files'],
            ['label' => 'Add', 'path' => '/panel/files/add'],
        ];

        $file = new File();
        $disks = static::$disks;
        $breadCount = count($bread);
        $multimedia = Tag::getAllMultimedia();

        return view('panel.files.add', compact(
            'bread', 'breadCount', 'file', 'disks', 'multimedia'));
    }

    /**
     * Add new link as a file view
     *
     * @return Illuminate\Support\Facades\View
     */
    public function addLink()
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Files', 'path' => '/panel/files'],
            ['label' => 'Add Link', 'path' => '/panel/files/addlink'],
        ];

        $file = new File();
        $breadCount = count($bread);
        $multimedia = Tag::getAllMultimedia();

        return view('panel.files.addlink', compact(
            'bread', 'breadCount', 'file', 'multimedia'));
    }

    /**
     * Upload new file and save details in database
     *
     * @param FileUploadRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function create(FileUploadRequest $request)
    {
        try {
            $file = new File();
            $uploadedFile = $request->file('file');
            $fileName = pathinfo(
                $uploadedFile->getClientOriginalName(),
                PATHINFO_FILENAME);
            $name = $request->input('filename') ? : $fileName;
            $sig_id = $request->input('sig_id') ? : null;
            $file->name = PagesController::uploadFile(
                $uploadedFile,
                $request['disk'],
                $name);
            $file->sig_id = $sig_id;
            $file->path = static::$disks[$request['disk']];
            $file->type = $uploadedFile->getClientMimeType();
            $file->user_id = Auth::user()->id;
            $file->save();

            $file->updateTags($request->toArray());
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        if (is_null($sig_id)) {
            return redirect('/panel/files');
        } else {
            return redirect('/panel/sig/files/' . $sig_id);
        }
    }

    /**
     * Add a new link as a file
     *
     * @param Request $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function createLink(Request $request)
    {
        try {
            $file = new File();
            $url = $request->input('url');
            $file->name = $url;
            $file->path = $url;
            $file->user_id = Auth::user()->id;
            $file->save();

            $file->updateTags($request->toArray());
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/files');
    }

    /**
     * Delete file. The route to this method only requires auth level,
     * but further checks are performed inside the function
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function delete($id)
    {
        $file = File::findOrFail($id);

        // determine if the user can delete the file; this could be done
        // in a middleware, but it would require instanciating the file
        // object twice (once in the middleware, another one here)
        $allow = false;
        if ($file->sig_id) {
            $allow = Auth::user()->canEditSig($file->sig_id);
        } else {
            $allow = Auth::user()->isAdmin();
        }

        if (!$allow) {
            return redirect()->guest('login');
        }

        try {
            $file = File::findOrFail($id);
            $disk = array_search($file->path, static::$disks);
            Storage::disk($disk)->delete($file->name);
            $file->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }

        if (Auth::user()->isAdmin()) {
            return redirect('/panel/files');
        }

        return redirect('/panel/sig/files/' . $file->sig_id);
    }


    /**
     * Toggle display in gallery
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function addToGallery($id)
    {
        $file = File::findOrFail($id);

        try {
            $file->gallery = $file->gallery === 1 ? 0 : 1;
            $file->save();
            Session::flash('success_message', 'Toggled gallery status.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }

        if (Auth::user()->isAdmin()) {
            return redirect('/panel/files');
        }

        return redirect('/panel/files/' . $file->sig_id);
    }


    /**
     * Render files edit interface
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $bread = array_merge(static::$filePanelCrumbs,
            [['label' => 'Edit', 'path' => "/panel/files/edit"]]);
        $breadCount = count($bread);

        $file = File::findOrFail($id);
        $multimedia = Tag::getAllMultimedia();
        $fileTags = $file->getTagIds();

        return view('panel.files.edit', compact(
            'file', 'bread', 'breadCount', 'multimedia', 'fileTags'));
    }


    /**
     * Update files
     *
     * @param int $id
     * @param FileFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function update($id, FileFormRequest $request)
    {
        $file = File::findOrFail($id);
        try {
            $input = $request->all();
            $file->fill($input);
            $file->save();

            $file->updateTags($request->toArray());
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/files');
    }
}

