<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Http\Requests;
use App\Http\Requests\ContactUsRequest;
use TwitterAPIExchange;
use App\Http\Controllers\NewsController;

class PagesController extends Controller
{
  public function index()
  {
    // get news to display
    $newsController = new NewsController();
    $news = $newsController->getNews();
    // get events to display
    $eventsController = new EventsController();
    $events = $eventsController->getEvents();
    // get tweets to display
    $tweets = $this->getTweets();
    $totalTweets = count($tweets);
    
    return view('pages.index', compact('news', 'events', 'tweets', 'totalTweets'));
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
    $name    = $request->input('name');
    $from    = $request->input('email');
    $message = $request->input('message');
    
    // send mail
    Page::sendForm($name, $from, $message);
    
    // set success message
    \Session::flash('success_message', 'Thank you for your message. We will get back to you shortly.');
    
    return view('pages.contact');
  }
  
  /**
   * Get array of tweets
   * @return array ["date", "text"]
   * @access public
   * @author Javier Arias <javier@arias.re>
   */
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
      $tweets[$key]['user'] = "@".$tweet->user->screen_name;
      $tweets[$key]['date'] = date("l jS F", strtotime($tweet->created_at));
      $originalText = $tweet->text;
      $text1 = preg_replace("/@(\w+)/i", "<a href=\"http://twitter.com/$1\">$0</a>", $originalText); // replace @user with link to user
      $text2 = preg_replace("/#(\w+)/i", "<a href=\"http://twitter.com/hashtag/$1\">$0</a>", $text1); // replace #hashtag with link to hashtag
      $tweets[$key]['text'] = $text2;
    }
    
    return $tweets;
  }
}
