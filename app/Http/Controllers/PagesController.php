<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Http\Requests;
use App\Http\Requests\ContactUsRequest;

use TwitterAPIExchange;

class PagesController extends Controller
{
  public function index()
  {
    
    $settings = array(
        'oauth_access_token' => "",
        'oauth_access_token_secret' => "",
        'consumer_key' => "pPc6U4S4jqWE5xcYNMMz06ssS",
        'consumer_secret' => "FEp6gAME28NoymZOj3i2z6fhWeGdB1yAW4NPyYRqyjfmqvsvWn"
    );

    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $getfield = '?screen_name=UKFluidsNetwork';
    $requestMethod = 'GET';

    $twitter = new TwitterAPIExchange($settings);
    $tweeets = $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();

    $tweets = json_decode($tweeets);
    
    return view('pages.index', compact('tweets'));
  }

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
