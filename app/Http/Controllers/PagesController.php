<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Http\Requests;
use App\Http\Requests\ContactUsRequest;

class PagesController extends Controller
{
  /**
   * Contact Us GET Controller
   * 
   * @return HTML
   * @author Robert Barczyk <robert@barczyk.net>
   */
  public function contact()
  {
    return view('pages.contact');
  }
    
  /**
   * Contact Us POST Controller
   * 
   * @param ContactUsRequest $request Validation Rules
   * @return HTML
   * @author Robert Barczyk <robert@barczyk.net>
   */
  public function sendMessage(ContactUsRequest $request) 
  {
    // validate input data from form
    $name    = $request->input('contact-name');
    $from    = $request->input('contact-email');
    $message = $request->input('contact-message');
    
    // send mail
    Page::sendForm($name, $from, $message);
    
    // set success message
    \Session::flash('success_message', 'Thank you for your message. We will get back to you shortly.');
    
    return view('pages.contact');
  }
}
