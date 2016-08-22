<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
  
  public function contact()
  {
    return view('pages.contact');
  }
    
  public function sendMessage(ContactUsRequest $request) 
  {
    $res = var_dump($_POST);
    // do some magic and return redirect('articles');
    //Article::create($request->all());
    return view('pages.contact', compact('res'));
  }
}
