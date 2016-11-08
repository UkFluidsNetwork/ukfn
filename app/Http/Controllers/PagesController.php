<?php

namespace App\Http\Controllers;

use App\Page;
use App\User;
use App\Title;
use App\Tag;
use App\Institution;
use App\Http\Requests\ContactUsRequest;
use TwitterAPIExchange;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Session;
use SEO;

class PagesController extends Controller
{

    /**
     * Home Page
     * 
     * @access public
     * @return \Illuminate\View\View
     */
    public function index()
    {
        SEO::setTitle('Home');
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
     * @access public
     * @return \Illuminate\View\View
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function contact()
    {
        SEO::setTitle('Contact Us');

        return view('pages.contact');
    }

    /**
     * Contact Us POST Controller
     * 
     * @access public
     * @param ContactUsRequest $request Validation Rules
     * @return \Illuminate\View\View
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function sendMessage(ContactUsRequest $request)
    {
        // validate input data from form
        $name = $request->input('name');
        $from = $request->input('email');
        $message = $request->input('message');

        // send mail
        Page::sendForm($name, $from, $message);

        // set success message
        Session::flash('success_message', 'Thank you for your message. We will get back to you shortly.');

        return view('pages.contact');
    }

    /**
     * Get array of tweets
     * 
     * @access public
     * @return array ["date", "text"]
     * @access public
     * @author Javier Arias <javier@arias.re>
     */
    public function getTweets()
    {
        $tweets = [];
        // set twitters keys for app authentication
        $settings = [
            'oauth_access_token' => "",
            'oauth_access_token_secret' => "",
            'consumer_key' => "pPc6U4S4jqWE5xcYNMMz06ssS",
            'consumer_secret' => "FEp6gAME28NoymZOj3i2z6fhWeGdB1yAW4NPyYRqyjfmqvsvWn"
        ];
        // define the type of query (user_timeline to get all tweets in an account)
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        // query string to search by user name
        $getfield = '?screen_name=UKFluidsNetwork&count=10';
        $requestMethod = 'GET';

        $twitter = new TwitterAPIExchange($settings);
        $rawTweeets = $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();

        $decodedTweets = json_decode($rawTweeets);

        foreach ($decodedTweets as $key => $tweet) {
            // retweets start with: RT @username: 
            if (preg_match('/^(R)(T) (@)([a-zA-Z0-9_]*)(: )/', $tweet->text)) {
                $tweets[$key]['user'] = $tweet->entities->user_mentions[0]->name; // it is a retweet, use original author
                $textToFormat = preg_replace('/^(R)(T) (@)([a-zA-Z0-9_]*)(: )/', '', $tweet->text);
            } else {
                $tweets[$key]['user'] = $tweet->user->name; // not a retweet
                $textToFormat = $tweet->text; // use original text
            }
            // link to tweet on twitter
            $tweets[$key]['link'] = "https://twitter.com/" . $tweet->user->screen_name . "/status/" . $tweet->id;
            // date posted
            $tweets[$key]['date'] = date("l jS F", strtotime($tweet->created_at));
            // format the text
            $text1 = preg_replace("/@(\w+)/i", "<a href=\"http://twitter.com/$1\">$0</a>", $textToFormat); // replace @user with link to user
            $text2 = preg_replace("/#(\w+)/i", "<a href=\"http://twitter.com/hashtag/$1\">$0</a>", $text1); // replace #hashtag with link to hashtag
            $tweets[$key]['text'] = $text2;
        }

        return $tweets;
    }

    public function myAccount()
    {
        SEO::setTitle('My Account');

        $titles = Title::all();
        $institutions = Institution::all();
        $subDisciplines = Tag::getAllDisciplines();
        $applicationAreas = Tag::getAllApplicationAreas();
        $techniques = Tag::getAllTechniques();
        $facilities = Tag::getAllFacilities();
        $curDisciplinesCategory = null;
        $curApplicationCategory = null;

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'My Account', 'path' => '/myaccount']
        ];
        $breadCount = count($bread);

        return view('pages.myaccount', compact('titles', 'subDisciplines', 'applicationAreas', 'techniques', 'institutions', 'facilities', 'curDisciplinesCategory', 'curApplicationCategory', 'bread', 'breadCount'));
    }

    public function changePassword()
    {
        SEO::setTitle('Change Password');

        $bread = [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'My Account', 'path' => '/myaccount'],
            ['label' => 'Change Password', 'path' => '/myaccount/password']
        ];

        $breadCount = count($bread);
        return view('pages.password', compact('bread', 'breadCount'));
    }
}
