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
    public function getNews()
    {
        $news = [];
        $newsData = News::getNews("created_at", "desc", 15);

        foreach ($newsData as $key => $new) {
            $news[$key]['title'] = $new->title;
            $news[$key]['start'] = date("l jS F", strtotime($new->created_at));
            $news[$key]['description'] = $new->description;
            $news[$key]['link'] = $new->link;
        }

        return $news;
    }

    public function view()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'News', 'path' => '/news']
        ];
        $breadCount = count($bread);

        $news = News::getNews();
        foreach ($news as $new) {
            $new->created = date("d M H:i", strtotime($new->created_at));
            $new->updated = date("d M H:i", strtotime($new->updated_at));
        }

        return view('panel.news.view', compact('news', 'bread', 'breadCount'));
    }

    public function edit($id)
    {
        $admin = new PanelController();
        if (!$admin->checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'News', 'path' => '/news'],
            ['label' => 'Edit', 'path' => '/news/edit'],
        ];
        $breadCount = count($bread);

        $new = News::findOrFail($id);

        return view('panel.news.edit', compact('new', 'bread', 'breadCount'));
    }

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
        return redirect('/news');
    }

    public function add()
    {
        $admin = new PanelController();
        if (!$admin->checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'News', 'path' => '/news'],
            ['label' => 'Add', 'path' => '/news/add'],
        ];
        $breadCount = count($bread);

        return view('panel.news.add', compact('bread', 'breadCount'));
    }
    
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
        return redirect('/news');
    }
    
    public function delete($id)
    {
        try {
            $new = News::findOrFail($id);
            $new->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/news');
    }
}
