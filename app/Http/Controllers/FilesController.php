<?php

namespace App\Http\Controllers;

use Auth;
use App\File;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\FileUploadRequest;

class FilesController extends Controller
{
    /**
     * Add new file view
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @return void
     */    
    public function add()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Files', 'path' => '/panel/files'],
            ['label' => 'Add', 'path' => '/panel/files/add'],
        ];
        
        $file = new File();
        $breadCount = count($bread);
        
        return view('panel.files.add', compact('bread', 'breadCount', 'file'));
    }
    
    /**
     * List of all files in admin panel
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @return void
     */
    public function index()
    { 
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Files', 'path' => '/panel/files']
        ];
        
        $breadCount = count($bread);
        
        $thisServer = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        
        $files = File::all();
        foreach ($files as $file) {
            $file->created = date("d M H:i", strtotime($file->created_at));
            $file->updated = date("d M H:i", strtotime($file->updated_at));
            $file->full_path = 'https://' . $thisServer . $file->path;
        }
                              
        return view('panel.files.index', compact('bread', 'breadCount', 'files'));
    }
    
    /**
     * Upload new file and save details in database
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @param FileUploadRequest $request
     * @return void
     */
    public function create(FileUploadRequest $request)
    { 
        try {
            $file = new File();
            $uploadedFile = $request->file('file');
            $prefix = $request->input('filename');
            $file->name = PagesController::uploadFile($uploadedFile, 'public-files', 'UKFN_' . $prefix . '_');
            $file->path = "/files";
            $file->type = $uploadedFile->getClientMimeType();
            $file->user_id = Auth::user()->id;
            $file->save();
                       
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/files');
    }
    
    /**
     * Delete file
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @param type $id  File id
     * @return void
     */
    public function delete($id)
    {
        try {
            $file = File::findOrFail($id);
            $file->deleted = 1;
            $file->save();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/files');
    }
}
