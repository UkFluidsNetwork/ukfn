<?php

namespace App\Http\Controllers;

use Auth;
use App\File;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\FileUploadRequest;

class FilesController extends Controller
{

    /**
     * List of all files in admin panel
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @return void
     */
    public function index()
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Files', 'path' => '/panel/files']
        ];
        
        $breadCount = count($bread);
        
        $thisServer = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        
        $files = File::all();
        foreach ($files as $file) {
            $file->created = PagesController::formatDate($file->created_at); 
            $file->updated = PagesController::formatDate($file->updated_at); 
            $file->full_path = url($file->path . "/" . $file->name);
        }
                              
        return view('panel.files.index', compact('bread', 'breadCount', 'files'));
    }

    /**
     * Add new file view
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @return void
     */    
    public function add()
    {
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
            $fileName = pathinfo(
                $uploadedFile->getClientOriginalName(), 
                PATHINFO_FILENAME); 
            $name = $request->input('filename') ? : $fileName;
            $file->name = PagesController::uploadFile(
                $uploadedFile, 
                'public-files', 
                $name);
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
