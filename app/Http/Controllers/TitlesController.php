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
     *
     * @return Illuminate\Support\Facades\View
     */
    public function view()
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Titles', 'path' => '/panel/titles']
        ];
        $breadCount = count($bread);

        $titles = Title::all();
        foreach ($titles as $title) {
            $title->created = PagesController::formatDate($title->created_at);
            $title->updated = PagesController::formatDate($title->updated_at);
        }

        return view('panel.titles.view',
                    compact('titles', 'bread', 'breadCount'));
    }

    /**
     * Edit titles
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Titles', 'path' => '/panel/titles'],
            ['label' => 'Edit', 'path' => '/panel/titles/edit'],
        ];
        $breadCount = count($bread);

        $title = Title::findOrFail($id);

        return view('panel.titles.edit',
                    compact('title', 'bread', 'breadCount'));
    }

    /**
     * Update titles
     *
     * @param int $id
     * @param EventsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
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
     *
     * @param EventsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
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
