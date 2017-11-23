<?php

namespace App\Http\Controllers;

use Auth;
use App\News;
use App\Http\Requests\NewsFormRequest;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{

    /**
     * Default breadcrumbs for /panel/news
     *
     * @var array
     */
    private static $crumbs = [
        ['label' => 'Panel', 'path' => '/panel'],
        ['label' => 'News', 'path' => '/panel/news']
    ];

    /**
     * Get list of news formatted and ordered by date
     *
     * @return array
     */
    public static function getNews()
    {
        $news = News::getNews("created_at", "desc", 10);

        foreach ($news as $new) {
            $new->date = PagesController::formatDate($new->created_at);
            $new->description = PagesController::makeLinksInText(
                                    $new->description);
        }

        return $news;
    }

    /**
     * List all news
     *
     * @return Illuminate\Support\Facades\View
     */
    public function view()
    {
        $bread = static::$crumbs;
        $breadCount = count($bread);

        $news = News::getNews();
        foreach ($news as $new) {
            $new->created = PagesController::formatDate($new->created_at);
            $new->updated = PagesController::formatDate($new->updated_at);
        }

        return view('panel.news.view', compact('news', 'bread', 'breadCount'));
    }

    /**
     * Edit news
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $crumb =  [['label' => 'Edit', 'path' => '/panel/news/edit']];
        $bread = array_merge(static::$crumbs, $crumb);
        $breadCount = count($bread);

        $new = News::findOrFail($id);

        return view('panel.news.edit', compact('new', 'bread', 'breadCount'));
    }

    /**
     * Update news
     *
     * @param int $id
     * @param EventsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
        $crumb =  [['label' => 'Add', 'path' => '/panel/news/add']];
        $bread = array_merge(static::$crumbs, $crumb);
        $breadCount = count($bread);

        return view('panel.news.add', compact('bread', 'breadCount'));
    }

    /**
     * Create news
     *
     * @param EventsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
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

