<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\File;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\FileUploadRequest;

class FilesController extends Controller
{

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
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Files', 'path' => '/panel/files']
        ];

        $breadCount = count($bread);

        $thisServer = filter_input(INPUT_SERVER, 'REMOTE_ADDR');

        $files = File::all()->sortByDesc("created_at");
        foreach ($files as $file) {
            $file->created = PagesController::formatDate($file->created_at);
            $file->updated = PagesController::formatDate($file->updated_at);
            $file->full_path = url($file->path . "/" . $file->name);
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

        return view('panel.files.add',
                    compact('bread', 'breadCount', 'file', 'disks'));
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
}

