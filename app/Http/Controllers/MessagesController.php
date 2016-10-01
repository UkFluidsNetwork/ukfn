<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Message;
use Carbon\Carbon;
use App\Http\Controllers\PanelController;

class MessagesController extends Controller
{
    /**
     * Render all messages in Admin panel
     * 
     * @return type
     * @access public
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function view()
    {
        if(!PanelController::checkIsAdmin()) {
          return redirect('/');
        }
        
        $list = Message::getAll();
        $messagesList = [];
        $index = 0;
        
        foreach ($list as $result) {
            $messagesList[$index]['from']           = $result->from;
            $messagesList[$index]['to']             = ($result->mailinglist === '0' ? $result->to : 'Mailing List');
            $messagesList[$index]['subject']        = $result->subject;
            $messagesList[$index]['body']           = $result->body;
            $messagesList[$index]['visibility']     = ($result->public === '0' ? 'Private (not displayed in admin)' : 'Displayed in admin');
            $messagesList[$index]['mailingList']    = $result->mailinglist;
            $messagesList[$index]['attachment']     = $result->attachment;
            $messagesList[$index]['created_at']     = Carbon::parse($result->created_at)->format('l jS F, H:i');
            if ($result->mailinglist) {
                $messagesList[$index]['visibility'] = 'Displayed in admin (under sent to mailing list)';
            } else {
                $messagesList[$index]['visibility'] = $result->public ? 'Displayed in admin (under sent to points of contact)' : 'Private (not displayed in admin)';
            }
            $index++;
        }
            
        // Bread crumbs array
        $bread = [
            ['label' => 'Home', 'path'=>'/'],
            ['label' => 'Admin','path' => '/admin'],
            ['label' => 'Messages','path' => '/messages']
        ];
        
        $breadCount  = count($bread);
        
        return view('panel.messages.view', compact('bread', 'breadCount', 'messagesList'));
    }
    
    /**
     * Return an array of messages with their created_at date formatted
     * @author Javier Arias <ja573@cam.ac.uk>
     * @static
     * @access public
     * @return array
     * @param array $messages
     */
    public static function formatMessages($messages)
    {
        $formattedMessages = [];
        foreach ($messages as $key => $message) {
            $formattedMessages[$key] = $message;
            $formattedMessages[$key]->date = date("l jS F", strtotime($message->created_at));
        }
        
        return $formattedMessages;
    }
}
