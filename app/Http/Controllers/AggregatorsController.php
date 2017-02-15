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
     * View all aggregators / feeds in admin panel
     * @author Robert Barczyk <robert@barczyk.net>
     * @return void
     */
    public function view()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
                ['label' => 'Panel', 'path' => '/panel'],
                ['label' => 'Talks', 'path' => '/panel/talks'],
                ['label' => 'RSS Feeds', 'path' => '/panel/talks/feeds']
        ];

        $breadCount = count($bread);

        $aggregators = Aggregator::all();

        return view('panel.aggregators.viewall', compact('aggregators','bread', 'breadCount'));
    }

    public function add()
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
                ['label' => 'Panel', 'path' => '/panel'],
                ['label' => 'Talks', 'path' => '/panel/talks'],
                ['label' => 'RSS Feeds', 'path' => '/panel/talks/feeds'],
                ['label' => 'Add', 'path' => '/panel/talks/feeds/add']
        ];

        $breadCount = count($bread);

        $aggregator = new Aggregator();
        
        return view('panel.aggregators.add', compact('bread', 'breadCount', 'aggregator'));
    }

    /**
     * Edit selected aggregator / RSS feed
     * @author Robert Barczyk <robert@barczyk.net>
     * @param intiger $id
     * @return void
     */
    public function edit($id)
    {
        if (!PanelController::checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
                ['label' => 'Panel', 'path' => '/panel'],
                ['label' => 'Talks', 'path' => '/panel/talks'],
                ['label' => 'RSS Feeds', 'path' => '/panel/talks/feeds'],
                ['label' => 'Edit', 'path' => '/panel/talks/feeds/edit']
        ];
        $breadCount = count($bread);

        $aggregator = Aggregator::findOrFail($id);


        return view('panel.aggregators.edit', compact('bread', 'breadCount', 'aggregator'));
    }

    /**
     * Delete selected aggregator / feed via admin panel
     * @author Robert Barczyk <robert@barczyk.net>
     * @param intiger $id aggregator id
     * @return void
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
     * @author Robert Barczyk <robert@barczyk.net>
     * @param intiger $id
     * @param AggregatorsFormRequest $request
     * @return void
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
     * @author Robert Barczyk <robert@barczyk.net>
     * @param AggregatorsFormRequest $request
     * @return void
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
     * @author Robert Barczyk <robert@barczyk.net>
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