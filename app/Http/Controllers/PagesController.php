<?php

namespace App\Http\Controllers;

use App;
use SEO;
use App\Page;
use Auth;
use App\User;
use App\Title;
use App\Tag;
use App\Message;
use App\Institution;
use App\Http\Requests\ContactUsRequest;
use App\Http\Requests\PreferencesRequest;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Requests\AcademicDetailsRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Controllers\MailingController;
use TwitterAPIExchange;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MessagesController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use stdClass;
use Storage;

class PagesController extends Controller
{

    /**
     * Default breadcrumbs for /myaccount
     *
     * @var array
     */
    private static $myAccountCrumbs = [
        ['label' => 'My Account', 'path' => '/myaccount']
    ];

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
        $news = NewsController::getNews();
        // get events to display
        $events = EventsController::getEvents();
        // get tweets to display
        $tweets = self::getTweets('UKFluidsNetwork');
        $totalTweets = count($tweets);
        return view('pages.index', compact('news', 'events', 'tweets', 'totalTweets'));
    }

    /**
     * Render "About" section
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        SEO::setTitle('About');
        SEO::setDescription('Find more about the grants that support UKFN, '
            . 'the proposal documents, minutes of the meetings held '
            . 'by the panel, a list of institutional points of contact, '
            . 'and a summary of the emails we send to our mailing list.');

        $listMessages = Message::getMailinglistMessages();
        $publicMessages = Message::getPublicMessages();
        $listEmails = MessagesController::formatMessages($listMessages);
        $publicEmails = MessagesController::formatMessages($publicMessages);
        $totalListEmails = count($listEmails);
        $totalPublicEmails = count($publicEmails);

        return view('pages.about', compact('listEmails', 'publicEmails',
                                      'totalListEmails', 'totalPublicEmails'));
    }

    /**
     * Display a message sent to the mailing list, or made public, given and ID
     *
     * @param int $id Message ID
     * @return \Illuminate\View\View
     */
    public function viewMessage($id)
    {
        $message = Message::findOrFail($id);
        if ($message->public || $message->mailinglist) {
            $message->date = date("l jS F", strtotime($message->created_at));
            $message->text = nl2br(e($message->body));
            return view('pages.viewmessage', compact('message'));
        } else {
            App::abort(404);
        }
    }

    /**
     * Send message from contact form
     *
     * @param ContactUsRequest $request Validation Rules
     * @return \Illuminate\View\View
     */
    public function sendMessage(ContactUsRequest $request)
    {
        $name = $request->input('name');
        $from = $request->input('email');
        $message = $request->input('message');

        Page::sendForm($name, $from, $message);

        Session::flash('success_message',
              'Thank you for your message. We will get back to you shortly.');

        return view('pages.about');
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

        foreach ($decodedTweets as $fullTweet) {
            $tweet = new stdClass();
            // retweets start with: RT @username:
            if (preg_match('/^(R)(T) (@)([a-zA-Z0-9_]*)(: )/', $fullTweet->text)) {
                $tweet->user = $fullTweet->entities->user_mentions[0]->name; // it is a retweet, use original author
                $textToFormat = preg_replace('/^(R)(T) (@)([a-zA-Z0-9_]*)(: )/', '', $fullTweet->text);
            } else {
                $tweet->user = $fullTweet->user->name; // not a retweet
                $textToFormat = $fullTweet->text; // use original text
            }
            // include images/videos if it has any
            if (isset($fullTweet->entities->media)) {
                $tweet->media = [];
                foreach ($fullTweet->entities->media as $media) {
                    $tweetMedia = new stdClass();
                    $tweetMedia->url = isset($media->media_url_https) ? $media->media_url_https : $media->media_url;
                    $tweetMedia->type = $media->type;
                    $tweet->media[] = $tweetMedia;
                }
            }
            // link to tweet on twitter
            $tweet->link = "https://twitter.com/" . $fullTweet->user->screen_name . "/status/" . $fullTweet->id;
            // date posted
            $tweet->date = self::formatDate($fullTweet->created_at);
            // format the text
            $text = self::makeLinksInText($textToFormat); // replace urls with anchor tags
            $text = preg_replace("/@(\w+)/i", "<a href=\"http://twitter.com/$1\">$0</a>", $text); // replace @user with link to user
            $text = preg_replace("/#(\w+)/i", "<a href=\"http://twitter.com/hashtag/$1\">$0</a>", $text); // replace #hashtag with link to hashtag
            $tweet->text = $text;

            $tweets[] = $tweet;
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

        $bread = static::$myAccountCrumbs;
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

        $bread = array_merge(static::$myAccountCrumbs, [['label' => 'Personal Details', 'path' => '/myaccount/personal']]);
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

        $bread = array_merge(static::$myAccountCrumbs, [['label' => 'Academic Details', 'path' => '/myaccount/academic']]);
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

        $bread = array_merge(static::$myAccountCrumbs, [['label' => 'Change Password', 'path' => '/myaccount/password']]);
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

        $bread = array_merge(static::$myAccountCrumbs, [['label' => 'Preferences', 'path' => '/myaccount/preferences']]);
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
     * Format a date or date range
     *
     * @author Javier Arias <ja573@cam.ac.uk>
     * @param string $start
     * @param string $end
     * @return string
     */
    public static function formatDate($start, $end = null)
    {
        $dateStart = new DateTime($start);

        $includeTime = $dateStart->format("H:i:s") !== "00:00:00";
        $format = $includeTime ? "j F Y g:ia" : "j F Y";
        $date = $dateStart->format($format);

        if ($end === null || $end === "" || $end === "0000-00-00 00:00:00" || $start === $end) {
            return $date;
        }

        $dateEnd = new DateTime($end);
        $sameMonth = $dateStart->format("m") === $dateEnd->format("m");
        $sameYear = $dateStart->format("Y") === $dateEnd->format("Y");

        $date = $dateStart->format("j F Y - ") . $dateEnd->format("j F Y");

        if ($sameYear) {
            $date = $dateStart->format("j F - ") . $dateEnd->format("j F Y");
        }

        if ($sameMonth && $sameYear) {
            $date = $dateStart->format("j-") . $dateEnd->format("j F Y");
        }

        return $date;
    }

    /**
     * When a $name is provided add a timestamp and replace whitespace with
     * underscores. When no $name is given a timestamp is returned.
     *
     * @param string $name an optional file name to include in the result
     * @return string
     */
    public static function sanitizeFilename($name = "")
    {
        $fileName = $name ? $name . "." . time() : time();
        return str_replace(' ', '_', $fileName);
    }

    /**
     * Move a temporary file from form into its final location and get its path
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $disk name of the storage::disk()
     * @param string|null $name the final name of the file
     * @return string|null the name of the file if upload succeeded or null if not
     */
    public static function uploadFile($file, $disk, $name = null)
    {
        if ($file === null) {
            return null;
        }

        try {
            $location = Storage::disk($disk)->getDriver()->getAdapter()->getPathPrefix();
        } catch (Exception $ex) {
            Session:flash('error_message', $ex);
        }

        $fileName = self::sanitizeFilename($name);
        $fileName .= "." . $file->getClientOriginalExtension();

        $fileMoved = $file->move($location, $fileName);
        if ($fileMoved) {
            return $fileName;
        }

        return null;
    }
}
