<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventsFormRequest;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Event;
use DateTime;

class EventsController extends Controller
{

    /**
     * Get list of events formatted and ordered by date.
     * We want to display newly created events first, with a "new" flag,
     * followed by the rest of the, non past, events.
     *
     * @return array
     */
    public static function getEvents()
    {
        $events = [];
        $today = new DateTime();
        $todayFormated = $today->format('Y-m-d');
        $threshold = $today->modify('-14 days')->format('Y-m-d');

        $newEvents = Event::getEvents(
            "created_at",
            "desc",
            [["created_at", ">=", $threshold]]
        );

        $oldEvents = Event::getEvents(
            "start",
            "asc",
            [["created_at", "<", $threshold], ["start", ">=", $todayFormated]]
        );

        $eventsData = $newEvents + $oldEvents;

        foreach ($eventsData as $event) {
            $event->subtitle = $event->subtitle ? ", " . $event->subtitle : '';
            $event->date = PagesController::formatDate(
                                  $event->start, $event->end);
            $event->description = PagesController::makeLinksInText(
                                  $event->description);
            $event->new = $event->created_at >= $threshold;
            $events[] = $event;
        }

        return $events;
    }

    /**
     * List all events
     *
     * @return void
     * @return Illuminate\Support\Facades\View
     */
    public function view()
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Events', 'path' => '/panel/events']
        ];
        $breadCount = count($bread);

        $events = Event::getEvents();
        foreach ($events as $event) {
            $event->created = PagesController::formatDate($event->created_at);
            $event->updated = PagesController::formatDate($event->updated_at);
            $event->date    = PagesController::formatDate($event->start);
        }

        return view('panel.events.view',
                    compact('events', 'bread', 'breadCount'));
    }

    /**
     * Edit an event
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit($id)
    {
        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Events', 'path' => '/panel/events'],
            ['label' => 'Edit', 'path' => '/panel/events/edit'],
        ];
        $breadCount = count($bread);

        $event = Event::findOrFail($id);

        return view('panel.events.edit',
                    compact('event', 'bread', 'breadCount'));
    }

    /**
     * Update an event
     *
     * @param int $id
     * @param EventsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
        return redirect('/panel/events');
    }

    /**
     * Add an event
     *
     * @param int $id
     * @return Illuminate\Support\Facades\View
     */
    public function add()
    {
        $admin = new PanelController();
        if (!$admin->checkIsAdmin()) {
            return redirect('/');
        }

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Events', 'path' => '/panel/events'],
            ['label' => 'Add', 'path' => '/panel/events/add'],
        ];
        $breadCount = count($bread);

        return view('panel.events.add', compact('bread', 'breadCount'));
    }

    /**
     * Create an event
     *
     * @access public
     * @param EventsFormRequest $request
     * @return Illuminate\Support\Facades\Redirect
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
        return redirect('/panel/events');
    }

    /**
     * Delete an event
     *
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
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
        return redirect('/panel/events');
    }
}
