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
    // get tweets to display
    $tweets = $this->getTweets();
    // get number of tweets
    $totalTweets = count($tweets);
    
    return view('pages.index', compact('tweets', 'totalTweets'));
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
  
  public function getTweets()
  {
    $tweets = [];
    // set twitters keys for app authentication
    $settings = array(
        'oauth_access_token' => "",
        'oauth_access_token_secret' => "",
        'consumer_key' => "pPc6U4S4jqWE5xcYNMMz06ssS",
        'consumer_secret' => "FEp6gAME28NoymZOj3i2z6fhWeGdB1yAW4NPyYRqyjfmqvsvWn"
    );
    // define the type of query (user_timeline to get all tweets in an account)
    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    // query string to search by user name
    $getfield = '?screen_name=UKFluidsNetwork';
    $requestMethod = 'GET';

    $twitter = new TwitterAPIExchange($settings);
    $rawTweeets = $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();

    $decodedTweets = json_decode($rawTweeets);
    
    foreach($decodedTweets as $key => $tweet) {
      $tweets[$key]['date'] = date("d M Y", strtotime($tweet->created_at));
      $originalText = $tweet->text;
      $text = preg_replace("/@(\w+)/i", "<a href=\"http://twitter.com/$1\">$0</a>", $originalText);
      $tweets[$key]['text'] = $text;
    }
    
    return $tweets;
  }
}
