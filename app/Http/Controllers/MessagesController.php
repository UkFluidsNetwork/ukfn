<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\Http\Controllers\PanelController;

class MessagesController extends Controller
{

    /**
     * Render list of messages
     *
     * @return Illuminate\Support\Facades\View
     */
    public function view()
    {
        $messages = self::formatMessages(Message::getAll(), "l jS F, H:i");

        $bread = [
            ['label' => 'Panel', 'path' => '/panel'],
            ['label' => 'Messages', 'path' => '/panel/messages']
        ];
        $breadCount = count($bread);

        return view('panel.messages.view',
                    compact('bread', 'breadCount', 'messages'));
    }

    /**
     * Return an array of messages with their created_at date formatted
     *
     * @param array $messages array of stdObjects
     * @param string $dateFormat
     * @return array
     */
    public static function formatMessages($messages, $dateFormat = "l jS F Y")
    {
        $formattedMessages = [];
        foreach ($messages as $key => $message) {
            $formattedMessages[$key] = $message;
            $formattedMessages[$key]->body = nl2br(e($message->body));
            $formattedMessages[$key]->sentTo = $message->mailinglist
                                               ? 'Mailing List'
                                               : $message->to;
            $formattedMessages[$key]->date = date($dateFormat,
                                             strtotime($message->created_at));

            if ($message->mailinglist) {
                $formattedMessages[$key]->visibility =
                    'Displayed in admin (under sent to mailing list)';
            } else {
                $formattedMessages[$key]->visibility = $message->public
                    ? 'Displayed in admin (under sent to points of contact)'
                    : 'Private (not displayed in admin)';
            }

            $user = User::findOrFail($message->user_id);
            $formattedMessages[$key]->sentBy = $user->name
                                               . " " . $user->surname;
        }

        return $formattedMessages;
    }
}

