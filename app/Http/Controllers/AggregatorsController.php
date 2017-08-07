<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AggregatorsFormRequest;
use App\Aggregator;
use Illuminate\Support\Facades\Session;


class AggregatorsController extends Controller
{

    /**
     * List all feeds
     *
     * @return Illuminate\Support\Facades\View
     */
    public function view()
    {
        $bread = [
                ['label' => 'Panel', 'path' => '/panel'],
                ['label' => 'Talks', 'path' => '/panel/talks'],
                ['label' => 'RSS Feeds', 'path' => '/panel/talks/feeds']
        ];

        $breadCount = count($bread);

        $aggregators = Aggregator::all();

        return view('panel.aggregators.viewall',
                    compact('aggregators','bread', 'breadCount'));
    }

    /**
     * Render aggregator add form
     *
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
        $bread = [
                ['label' => 'Panel', 'path' => '/panel'],
                ['label' => 'Talks', 'path' => '/panel/talks'],
                ['label' => 'RSS Feeds', 'path' => '/panel/talks/feeds'],
                ['label' => 'Add', 'path' => '/panel/talks/feeds/add']
        ];

        $breadCount = count($bread);

        $aggregator = new Aggregator();

        return view('panel.aggregators.add',
                    compact('bread', 'breadCount', 'aggregator'));
    }

    /**
     * Edit selected aggregator / RSS feed
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $bread = [
                ['label' => 'Panel', 'path' => '/panel'],
                ['label' => 'Talks', 'path' => '/panel/talks'],
                ['label' => 'RSS Feeds', 'path' => '/panel/talks/feeds'],
                ['label' => 'Edit', 'path' => '/panel/talks/feeds/edit']
        ];
        $breadCount = count($bread);

        $aggregator = Aggregator::findOrFail($id);


        return view('panel.aggregators.edit',
                    compact('bread', 'breadCount', 'aggregator'));
    }

    /**
     * Delete selected aggregator / feed via admin panel
     *
     * @param int $id aggregator id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function delete($id)
    {
        try {
            $feed = Aggregator::findOrFail($id);
            $feed->deleted = 1;
            $feed->save();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/talks/feeds');
    }

    /**
     * Update selected aggregator
     *
     * @param int $id
     * @param AggregatorsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function update($id, AggregatorsFormRequest $request)
    {
        try {
            $aggregator = Aggregator::findOrFail($id);
            $input = $request->all();
            $aggregator->fill($input);
            $aggregator->save();
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/panel/talks/feeds/');
    }

    /**
     * Add new RSS feed / aggregator
     *
     * @param AggregatorsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function create(AggregatorsFormRequest $request)
    {
        try {
            $aggregator = new Aggregator();
            $input = $request->all();
            $aggregator->fill($input);
            $aggregator->save();

            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }

        return redirect('/panel/talks/feeds');
    }

    /**
     * Return array of aggregator_id => name
     *
     * @return array
     */
    public static function getSelect()
    {
        $aggregators = Aggregator::all();
        $formated = [];
        foreach ($aggregators as $aggregator) {
            $formated[$aggregator->id] = $aggregator->longname;
        }
        return $formated;
    }
}

