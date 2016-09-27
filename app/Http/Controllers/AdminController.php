<?php

namespace App\Http\Controllers;

use App;
use SEO;
use App\Message;
use App\Http\Controllers\MessagesController;

class AdminController extends Controller
{

    public function index()
    {
        SEO::setTitle('Admin');
        SEO::setDescription('Find more about the grants that support UKFN, '
            . 'the proposal documents, minutes of the meetings held by the panel, a list of institutional points of contact,'
            . 'and a summary of the emails we send to our mailing list.');
    
        $listMessages = Message::getMailinglistMessages();
        $publicMessages = Message::getPublicMessages();
        $listEmails = MessagesController::formatMessages($listMessages);
        $publicEmails = MessagesController::formatMessages($publicMessages);
        $totalListEmails = count($listEmails);
        $totalPublicEmails = count($publicEmails);

        return view('admin.index', compact('listEmails', 'publicEmails', 'totalListEmails', 'totalPublicEmails'));
    }
    
    public function viewMessage($id)
    {
        $message = Message::findOrFail($id);
        if ($message->public || $message->mailinglist) {
            $message->date = date("l jS F", strtotime($message->created_at));
            $message->text = nl2br(e($message->body));
            return view('admin.viewmessage', compact('message'));
        } else {
            App::abort(404);
        }
    }
}
