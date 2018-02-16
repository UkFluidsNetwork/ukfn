@extends('layouts.master')
@section('content')

  <h2 class='line-break'>
      <span class="label label-new label-ukfn-red pull-left margin-right">
          New
      </span> UK Fluids Network dissertation prize
  </h2>

  <div class="well">
    <p>
        The UKFN invites nominations for the best Fluid Mechanics-themed doctoral thesis from 2017. The winner will receive a prize of £500 and, along with two runners-up, will be invited to present their work at the UK Fluids Conference in Manchester in September 2018.
    </p>
    <p>
        The following pdf gives full details of how to enter:
    </p>
    <p>
        [<a href="{{ asset('/files/Thesis_prize_nomination_details_180215.1518716438.pdf') }}">
            Thesis_prize_nomination_details_180215.1518716438.pdf
        </a>]
    </p>
    <p>
        <b>The closing date for nominations is 31 March 2018.</b>
    </p>
  </div>

  <br>
  <hr>
  <br>

  <h2 class='line-break'>
      Photo and Video Competition #2: the interface between solid and fluid mechanics
  </h2>

  <div style="text-align:center;">
    <div class="row">
    <div class="col-sm-6 col-xs-12">
      <a href="/competition/winner/photos/"
         class="btn btn-primary line-break-dbl"
         style="width: 100%; padding-bottom: 1em; padding-top: 1em; font-weight:bold;">
           Photo Competition Winner
       </a>
    </div>
    <div class="col-sm-6 col-xs-12">
      <a href="/competition/winner/videos/"
         class="btn btn-primary line-break-dbl"
         style="width: 100%; padding-bottom: 1em; padding-top: 1em; font-weight:bold;">
           Video Competition Winner
       </a>
    </div>
    </div>
  </div>

  <div class="well">
    <p>
        There will be a new competition in March. Check out the website, the newsletter and twitter for details.
    </p>
  </div>

  @if (false)
  <p><b>The closing date for entries is 30 November 2017.</b></p>

  <div class="container-fluid nopadding-left">
    <div class="row">
        <div class="col-sm-4 col-sm-push-8">
            <div class="bs-callout bs-callout-info">
                <div style="text-align:center;">
                    <a href="/competition/winner/photos/"
                       class="btn btn-primary line-break-dbl-top"
                       style="width: 100%; padding-bottom: 1em;
                              padding-top: 1em; font-weight:bold;">
                       Past Winner Photo
                   </a>
                </div>
                <div style="text-align:center;">
                    <a href="/competition/winner/videos/"
                       class="btn btn-primary line-break-dbl-top"
                       style="width: 100%; padding-bottom: 1em;
                              padding-top: 1em; font-weight:bold;">
                       Past Winner Video
                   </a>
                </div>
            </div>
        </div>
        <div class="col-sm-8 col-sm-pull-4">
            <div class="bs-callout bs-callout-danger">
              <h4>How to enter</h4>
              <ul>
                <li>You must be a UK-based fluid mechanics researcher, i.e. at a university, research institute, or company</li>
                <li>Email photos directly to <a href="mailto:competition@fluids.ac.uk">competition@fluids.ac.uk</a>. Submit videos by giving a link to a suitable data-sharing website, e.g. Dropbox.</li>
                <li>
                  In both cases, the covering email must contain the following information:
                  <ol type="a">
                    <li>Name and affiliation</li>
                    <li>Title (max 10 words)</li>
                    <li>Description, including whether (for photos) the image is a composite or has been enhanced (max 50 words)</li>
                    <li>Keywords (max 5)</li>
                    <li>A statement granting non-exclusive use of the media:
                      <p>
          “I have checked with my [supervisor/manager/sponsor] __________________ that I have permission to enter the proposed photo(s)/video(s) in the competition and give the UK Fluids Network the right to publish them on its website and elsewhere.”
                      </p>
                    </li>
                    <li>Whether the photo/video has won other competitions</li>
                    <li>Any due acknowledgements</li>
                  </ol>
                </li>
              </ul>
            </div>
            <div class="bs-callout bs-callout-danger">
              <h4>Guidelines/Tips</h4>
              <ul>
                <li>Your entry should ideally be of high quality, suitable for large-scale reproduction,
                    but we would still like to receive your entries if they are at a lower resolution</li>
                <li>Videos should preferably be a maximum of 5 minutes in length</li>
                <li>You may submit multiple entries with the same title if you are not sure which one is best</li>
              </ul>
            </div>
            <div class="bs-callout bs-callout-danger">
              <h4>Judging</h4>
                <ul>
                  <li>After the closing date, the UKFN website will display all entries and visitors to the website will be asked to vote for their favourite photo and video (voters will be identified via their email address). The winner will be decided by a combination of the most popular and the highest scoring as judged by a panel drawn from the UKFN Executive Committee and Advisory Board..</li>
                </ul>
            </div>
        </div>
    </div>
  </div>
@endif

@endsection
