<?php

namespace App\Http\Controllers;

use App\Page;
use Auth;
use App\User;
use App\Title;
use App\Tag;
use App\Institution;
use App\Http\Requests\ContactUsRequest;
use App\Http\Requests\PreferencesRequest;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Requests\AcademicDetailsRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Controllers\MailingController;
use TwitterAPIExchange;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Session;
use SEO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

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
        
        $bread = [
            ['label' => 'My Account', 'path' => '/myaccount']
        ];
        $breadCount = count($bread);
        
        return view('pages.myaccount', compact('bread', 'breadCount'));
    }

    public function personalDetails()
    {
        SEO::setTitle('Personal Details');

        $user = Auth::user();
        $titles = Title::all();

        $bread = [
            ['label' => 'My Account', 'path' => '/myaccount'],
            ['label' => 'Personal Details', 'path' => '/myaccount/personal']
        ];
        $breadCount = count($bread);

        return view('pages.personaldetails', compact('titles', 'bread', 'breadCount', 'user'));
    }

    public function academicDetails()
    {
        SEO::setTitle('Academic Details');

        $user = Auth::user();
        $userTags = $user->getTagIds();
        $userInstitutions = $user->getInstitutionIds();
        $institutions = Institution::all();
        $subDisciplines = Tag::getAllDisciplines();
        $applicationAreas = Tag::getAllApplicationAreas();
        $techniques = Tag::getAllTechniques();
        $facilities = Tag::getAllFacilities();
        $curDisciplinesCategory = null;
        $curApplicationCategory = null;

        $bread = [
            ['label' => 'My Account', 'path' => '/myaccount'],
            ['label' => 'Academic Details', 'path' => '/myaccount/academic']
        ];
        $breadCount = count($bread);

        return view('pages.academicdetails', compact('subDisciplines', 'applicationAreas', 'techniques', 'institutions', 'facilities', 'curDisciplinesCategory', 'curApplicationCategory', 'bread', 'breadCount', 'user', 'userTags', 'userInstitutions'));
    }

    public function changePassword()
    {
        SEO::setTitle('Change Password');

        $bread = [
            ['label' => 'My Account', 'path' => '/myaccount'],
            ['label' => 'Change Password', 'path' => '/myaccount/password']
        ];
        
        $breadCount = count($bread);
        return view('pages.password', compact('bread', 'breadCount'));
    }

    /**
     * Render the preferences view
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @access public
     * @return Illuminate\Support\Facades\View
     */
    public function preferences()
    {
        SEO::setTitle('Preferences');
        
        $user = User::findOrFail(Auth::user()->id);
        $subscription = !is_null($user->subscription['id']) && $user->subscription['deleted'] == 0;

        $bread = [
            ['label' => 'My Account', 'path' => '/myaccount'],
            ['label' => 'Preferences', 'path' => '/myaccount/preferences']
        ];
        
        $breadCount = count($bread);
        return view('pages.preferences', compact('bread', 'breadCount', 'subscription'));
    }
    
    public function updatePreferences(PreferencesRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $mailing = new MailingController;
        $subscription = $request->subscription;
        
        if ($subscription) {
            $mailing->subscribe($user->email, $user->id);
        } else {
            $mailing->cancelSubscription(null, $user->email, $user->id);            
        }
        
        Session::flash('message', 'Preferences saved.');
        Session::flash('alert-class', 'alert-success');

        return redirect('/myaccount');
    }
    
    public function updatePersonalDetails(PersonalDetailsRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->title_id = $request->title_id ? : null;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        
        if ($user->save()) {
            Session::flash('message', 'Details saved.');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'An error occurred.');
            Session::flash('alert-class', 'alert-danger');            
        }

        return redirect('/myaccount');
    }

    public function updateAcademicDetails(AcademicDetailsRequest $request)
    {
        $tagtypes = ['disciplines' => 1, 'applications' => 2, 'techniques' => 3, 'facilities' => 4];

        $user = User::findOrFail(Auth::user()->id);
        $user->orcidid = $request->orcidid;
        $user->url = $request->url;
        $user->save();

        // compare old and new tags to determine which ones we are deleting (in old but not in  new) and which ones we are adding (in new but not in old)
        $currentTags = $user->getTagIds();
        $inputTags = [];
        foreach ($tagtypes as $type) {
            if (is_array($request->$type)) {
                array_merge($inputTags, $request->$type);
            }
        }
        
        if (!empty($currentTags)) {
            foreach ($currentTags as $curTag) {
                if (!in_array($curTag, $inputTags)) {
                    $user->tags()->detach($curTag);
                }
            }
        }

        foreach ($tagtypes as $type => $key) {
            if (!empty($request->$type)) {
                foreach ($request->$type as $element) {
                    $id = is_numeric($element) ? $element : Tag::create(['name' => $element, 'category' => 'Other', 'tagtype_id' => $key]);
                    $user->tags()->attach($id);
                }
            }
        }

        // the same with institutions, we are attaching new institutions in input that are not in current and deattaching
        // institutions that were in current but not in the new ones
        $currentInstitutions = $user->getInstitutionIds();
        if (!empty($currentInstitutions)) {
            foreach ($currentInstitutions as $curInstitution) {
                if (!in_array($curInstitution, $request->institutions)) {
                    $user->institutions()->detach($curInstitution);
                }
            }
        }

        if (!empty($request->institutions)) {
            foreach ($request->institutions as $inputInstitution) {
                if (!in_array($inputInstitution, $currentInstitutions)) {
                    $id = is_numeric($inputInstitution) ? $inputInstitution : Institution::create(['name' => $inputInstitution]);
                    $user->institutions()->attach($id);
                }
            }
        }

        Session::flash('message', 'Details saved.');
        Session::flash('alert-class', 'alert-success');
        return redirect('/myaccount');
    }
    
    /**
     * Update user password
     * @param PasswordUpdateRequest $request
     * @return void
     * @author Robert Barczyk <robert@barczyk.net>
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {        
        if (Hash::check($request->password, Auth::user()->password)) {
            $user = Auth::user();
            $user->password = Hash::make($request->new_password);
            $user->save();
            Session::flash('message', 'Your password has been changed.');
            Session::flash('alert-class', 'alert-success');
            return redirect('/myaccount');
        } else {
            return Redirect::back()->withErrors(['password' => 'Current password is incorrect']);
        }
    }
}
