<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SigSuggestionFormRequest;
use App\Suggestion;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PanelController;

class SuggestionsController extends Controller
{

    public function postSuggestion(SigSuggestionFormRequest $request)
    {
        // validate input data from form
        $name = $request->input('name');
        $email = $request->input('email');
        $suggestion = $request->input('suggestion');
        $institution = $request->input('institution');

        // Add suggestion to the databse
        Suggestion::addSuggestion($name, $email, $institution, $suggestion);

        // set success message
        Session::flash('success_message', 'Thank you, your suggestion has been posted. ');
        return redirect('/sig');
    }

    public function view()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'SIG Suggestions', 'path' => '/suggestions']
        ];
        $breadCount = count($bread);

        $suggestions = Suggestion::getAllSuggestions();
        foreach ($suggestions as $suggestion) {
            $suggestion->created = date("d M H:i", strtotime($suggestion->created_at));
            $suggestion->updated = date("d M H:i", strtotime($suggestion->updated_at));
        }

        return view('sig.view', compact('suggestions', 'bread', 'breadCount'));
    }

    public function edit($id)
    {
        $admin = new PanelController();
        if (!$admin->checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Admin', 'path' => '/admin'],
            ['label' => 'SIG Suggestions', 'path' => '/suggestions'],
            ['label' => 'Edit', 'path' => '/suggestions/edit'],
        ];
        $breadCount = count($bread);

        $suggestion = Suggestion::findOrFail($id);

        return view('sig.edit', compact('suggestion', 'bread', 'breadCount'));
    }

    public function update($id, SigSuggestionFormRequest $request)
    {
        try {
            $suggestion = Suggestion::findOrFail($id);
            $input = $request->all();
            $suggestion->fill($input)->save();
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/suggestions');
    }

    public function delete($id)
    {
        try {
            $suggestion = Suggestion::findOrFail($id);
            $suggestion->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/suggestions');
    }
}
