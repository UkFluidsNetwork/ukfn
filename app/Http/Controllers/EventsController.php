<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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
    
    foreach($eventsData as $key => $event) {
      $events[$key]['title'] = $event->title;
      $events[$key]['subtitle'] = $event->subtitle ? ", " . $event->subtitle : '';
      $events[$key]['start'] = date("g:ia l jS F", strtotime($event->start));
      $events[$key]['description'] = $event->description; 
    }

    return $events;
  }
  
}
