<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventsFormRequest;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Event;

class EventsController extends Controller
{

    /**
     * Get list of events formatted and ordered by date
     * @return array
     * @access public
     * @author Javier Arias <javier@arias.re>
     */
    public function getEvents()
    {

        $events = [];
        $eventsData = Event::getEvents("start", "desc", 15);

        foreach ($eventsData as $key => $event) {
            $events[$key]['title'] = $event->title;
            $events[$key]['subtitle'] = $event->subtitle ? ", " . $event->subtitle : '';
            $events[$key]['start'] = date("g:ia l jS F", strtotime($event->start));
            $events[$key]['description'] = $event->description;
        }

        return $events;
    }

    /**
     * List all events
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
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Events', 'path' => '/events']
        ];
        $breadCount = count($bread);

        $events = Event::getEvents();
        foreach ($events as $event) {
            $event->created = date("d M H:i", strtotime($event->created_at));
            $event->updated = date("d M H:i", strtotime($event->updated_at));
            $event->date = date("g:ia l jS F", strtotime($event->start));
        }

        return view('panel.events.view', compact('events', 'bread', 'breadCount'));
    }

    /**
     * Edit an event
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
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Events', 'path' => '/events'],
            ['label' => 'Edit', 'path' => '/events/edit'],
        ];
        $breadCount = count($bread);

        $event = Event::findOrFail($id);

        return view('panel.events.edit', compact('event', 'bread', 'breadCount'));
    }

    /**
     * Update an event
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @param EventsFormRequest $request
     * @return void
     */
    public function update($id, EventsFormRequest $request)
    {
        try {
            $event = Event::findOrFail($id);
            $input = $request->all();
            $event->fill($input);
            $event->user_id = Auth::user()->id;
            $event->save();
            Session::flash('success_message', 'Edited succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/events');
    }

    /**
     * Add an event
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
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Events', 'path' => '/events'],
            ['label' => 'Add', 'path' => '/events/add'],
        ];
        $breadCount = count($bread);

        return view('panel.events.add', compact('bread', 'breadCount'));
    }

    /**
     * Create an event
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param EventsFormRequest $request
     * @return void
     */
    public function create(EventsFormRequest $request)
    {
        try {
            $event = new Event;
            $input = $request->all();
            $event->fill($input);
            $event->user_id = Auth::user()->id;
            $event->save();
            Session::flash('success_message', 'Added succesfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/events');
    }

    /**
     * Delete an event
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();
            Session::flash('success_message', 'Deleted successfully.');
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        return redirect('/events');
    }
}
