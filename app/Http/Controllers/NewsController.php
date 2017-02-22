<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsFormRequest;
use Illuminate\Support\Facades\Session;
use Auth;
use App\News;

class NewsController extends Controller
{

    /**
     * Get list of news formatted and ordered by date
     * @return array
     * @access public
     * @author Javier Arias <javier@arias.re>
     */
    public static function getNews()
    {
        $news = [];
        $newsData = News::getNews("created_at", "desc", 15);

        foreach ($newsData as $new) {
            $new->date = PagesController::formatDate($new->created_at);
            $new->description = PagesController::makeLinksInText($new->description);
            $news[] = $new;
        }

        return $news;
    }

    /**
     * List all news
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
            ['label' => 'News', 'path' => '/panel/news']
        ];
        $breadCount = count($bread);

        $news = News::getNews();
        foreach ($news as $new) {
            $new->created = date("d M H:i", strtotime($new->created_at));
            $new->updated = date("d M H:i", strtotime($new->updated_at));
        }

        return view('panel.news.view', compact('news', 'bread', 'breadCount'));
    }

    /**
     * Edit news
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
            ['label' => 'News', 'path' => '/panel/news'],
            ['label' => 'Edit', 'path' => '/panel/news/edit'],
        ];
        $breadCount = count($bread);

        $new = News::findOrFail($id);

        return view('panel.news.edit', compact('new', 'bread', 'breadCount'));
    }

    /**
     * Update news
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @param EventsFormRequest $request
     * @return void
     */
    public function update($id, NewsFormRequest $request)
    {
        try {
            $new = News::findOrFail($id);
            $input = $request->all();
            $new->fill($input);
            $new->user_id = Auth::user()->id;
            $new->save();
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/news');
    }

    /**
     * Add news
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
            ['label' => 'News', 'path' => '/panel/news'],
            ['label' => 'Add', 'path' => '/panel/news/add'],
        ];
        $breadCount = count($bread);

        return view('panel.news.add', compact('bread', 'breadCount'));
    }

    /**
     * Create news
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param EventsFormRequest $request
     * @return void
     */
    public function create(NewsFormRequest $request)
    {
        try {
            $new = new News;
            $input = $request->all();
            $new->fill($input);
            $new->user_id = Auth::user()->id;
            $new->save();
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/news');
    }

    /**
     * Delete news
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        try {
            $new = News::findOrFail($id);
            $new->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/news');
    }
}
