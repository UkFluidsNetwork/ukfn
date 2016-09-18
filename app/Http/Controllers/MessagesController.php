<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Message;
use Carbon\Carbon;
use App\Http\Controllers\AdminController;

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
        if(!AdminController::checkIsAdmin()) {
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
            $messagesList[$index]['visibility']     = ($result->public === '0' ? 'Private' : 'Public');
            $messagesList[$index]['mailingList']    = $result->mailinglist;
            $messagesList[$index]['created_at']     = Carbon::parse($result->created_at)->format('l jS F, H:i');
            $index++;
        }
            
        // Bread crumbs array
        $bread = [
            ['label' => 'Home', 'path'=>'/'],
            ['label' => 'Admin','path' => '/admin'],
            ['label' => 'Messages','path' => '/messages']
        ];
        
        $breadCount  = count($bread);
        
        return view('admin.messages.view', compact('bread', 'breadCount', 'messagesList'));
    }
}
