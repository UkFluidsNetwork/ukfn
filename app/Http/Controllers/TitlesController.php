<?php

namespace App\Http\Controllers;

use App\Http\Requests\TitlesFormRequest;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Title;

class TitlesController extends Controller
{

    /**
     * List all titles
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return void
     */
    public function view()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Titles', 'path' => '/panel/titles']
        ];
        $breadCount = count($bread);

        $titles = Title::all();
        foreach ($titles as $title) {
            $title->created = date("d M H:i", strtotime($title->created_at));
            $title->updated = date("d M H:i", strtotime($title->updated_at));
        }

        return view('panel.titles.view', compact('titles', 'bread', 'breadCount'));
    }

    /**
     * Edit titles
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        $admin = new PanelController();
        if (!$admin->checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Titles', 'path' => '/panel/titles'],
            ['label' => 'Edit', 'path' => '/panel/titles/edit'],
        ];
        $breadCount = count($bread);

        $title = Title::findOrFail($id);

        return view('panel.titles.edit', compact('title', 'bread', 'breadCount'));
    }

    /**
     * Update titles
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @param EventsFormRequest $request
     * @return void
     */
    public function update($id, TitlesFormRequest $request)
    {
        try {
            $title = Title::findOrFail($id);
            $input = $request->all();
            $title->fill($input);
            $title->save();
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/titles');
    }

    /**
     * Add titles
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function add()
    {
        $admin = new PanelController();
        if (!$admin->checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Titles', 'path' => '/panel/titles'],
            ['label' => 'Add', 'path' => '/panel/titles/add'],
        ];
        $breadCount = count($bread);

        return view('panel.titles.add', compact('bread', 'breadCount'));
    }

    /**
     * Create titles
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param EventsFormRequest $request
     * @return void
     */
    public function create(TitlesFormRequest $request)
    {
        try {
            $title = new Title;
            $input = $request->all();
            $title->fill($input);
            $title->save();
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/titles');
    }

    /**
     * Delete titles
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        try {
            $title = Title::findOrFail($id);
            $title->deleted = 1;
            $title->save();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/titles');
    }
}
