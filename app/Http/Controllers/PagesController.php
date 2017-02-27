<?php

namespace App\Http\Controllers;

use App\Page;
use Auth;
use App\User;
use App\Title;
use App\Tag;
use App\Institution;
use App\Sig;
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
        $news = [];
        $newsController = new NewsController();
        $rawNews = $newsController->getNews();
        foreach ($rawNews as $new) {
            $new['description'] = self::makeLinksInText($new['description']);
            $news[] = $new;
        }
        
        // get events to display
        $events = [];
        $eventsController = new EventsController();
        $rawEvents = $eventsController->getEvents();
        foreach ($rawEvents as $event) {
            $event['description'] = self::makeLinksInText($event['description']);
            $events[] = $event;
        }
        
        // get tweets to display
        $tweets = self::getTweets('UKFluidsNetwork');
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
    public static function getTweets($screenName, $maxTweets = 10)
    {
        $tweets = [];

        if (!$screenName) {
            return $tweets;
        }

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
        $getfield = "?screen_name=${screenName}&count=${maxTweets}";
        $requestMethod = 'GET';

        $twitter = new TwitterAPIExchange($settings);
        $rawTweets = $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();

        if (empty($rawTweets)) {
            return $tweets;
        }
        
        $decodedTweets = json_decode($rawTweets);

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
            $text = self::makeLinksInText($textToFormat); // replace urls with anchor tags
            $text = preg_replace("/@(\w+)/i", "<a href=\"http://twitter.com/$1\">$0</a>", $text); // replace @user with link to user
            $text = preg_replace("/#(\w+)/i", "<a href=\"http://twitter.com/hashtag/$1\">$0</a>", $text); // replace #hashtag with link to hashtag
            $tweets[$key]['text'] = $text;
        }

        return $tweets;
    }

    /**
     * Render my account view
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @return Illuminate\Support\Facades\View
     */
    public function myAccount()
    {
        SEO::setTitle('My Account');

        $bread = [
            ['label' => 'My Account', 'path' => '/myaccount']
        ];
        $breadCount = count($bread);

        return view('pages.myaccount', compact('bread', 'breadCount'));
    }

    /**
     * Render the personal details view
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @return Illuminate\Support\Facades\View
     */
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

    /**
     * Render the academic details view
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @return Illuminate\Support\Facades\View
     */
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

        $vars = [
            'subDisciplines',
            'applicationAreas',
            'techniques',
            'institutions',
            'facilities',
            'curDisciplinesCategory',
            'curApplicationCategory',
            'bread',
            'breadCount',
            'user',
            'userTags',
            'userInstitutions'
        ];

        return view('pages.academicdetails', compact($vars));
    }

    /**
     * Render the change password interface
     * 
     * @author Robert Barczyk <robert@barczyk.net>
     * @return Illuminate\Support\Facades\View
     */
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

    /**
     * Save the preferences of the user
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @param PreferencesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Save the personal details of the user
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @param PersonalDetailsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePersonalDetails(PersonalDetailsRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->title_id = $request->title_id ?: null;
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

    /**
     * Save the academic details of the user
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @param AcademicDetailsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAcademicDetails(AcademicDetailsRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->orcidid = $request->orcidid;
        $user->url = $request->url;
        $user->save();

        $user->updateTags($request->toArray());
        $user->updateInstitutions($request->institutions);

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
    
    /**
     * Convert raw URIs into anchor tags
     * 
     * @author Javier Arias <ja573@cam.ac.uk>
     * @param string $textToFormat
     * @return string
     */
    public static function makeLinksInText($textToFormat)
    {
        return preg_replace(
                "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/",
                "<a href=\"$0\">$0</a>",
                $textToFormat
            );
    }
    
    /**
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $disk name of the storage::disk()
     * @param string|null $name the final name of the file
     * @return string|boolean the name of the file if succeeded or false if not
     */
    public static function uploadFile($file, $disk, $name = null)
    {
        try {
            $location = Storage::disk($disk)->getDriver()->getAdapter()->getPathPrefix();
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }
        
        $fileName = $name !== null ? $name . time() : time();
        $fileName.= $file->getClientOriginalExtension();
        
        $fileMoved = $file->move($location, $fileName);
        
        if ($fileMoved) {
            return $fileName;
        }
        
        return false;
    }
}
