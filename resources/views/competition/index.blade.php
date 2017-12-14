@extends('layouts.master')
@section('content')

  <h2 class='line-break'>
      Photo and Video Competition #2: the interface between solid and fluid mechanics
  </h2>

  <div style="text-align:center;">
    <div class="row">
    <div class="col-sm-6 col-xs-12">
      <a href="/competition/vote/photos/"
         class="btn btn-primary line-break-dbl"
         style="width: 100%; padding-bottom: 1em; padding-top: 1em; font-weight:bold;">
           Photo entries
       </a>
    </div>
    <div class="col-sm-6 col-xs-12">
      <a href="/competition/vote/videos/"
         class="btn btn-primary line-break-dbl"
         style="width: 100%; padding-bottom: 1em; padding-top: 1em; font-weight:bold;">
           Video entries
       </a>
    </div>
    </div>
  </div>

  <div class="well">
    <p>
        The UK Fluids Network presents a new competition, open to all UK-based fluids researchers, for the best new photo and video in Fluid Mechanics on the theme <b>‘The interface between solid and fluid mechanics’</b>.
    <p>
  </div>
  <p>
  The UK Fluids Network wants to showcase new photos and videos from the UK fluids community, and is offering cash prizes of £200 for the best photo and the best video from a UK-based fluids researcher. The competition runs every 4 months and the winner will be selected by a combination of popular vote and a panel of judges drawn from the UKFN Executive Committee and Advisory Board.
  </p>
  <p>
      In this second competition, the photo or video should be on the subject <b>‘The interface between solid and fluid mechanics’</b>.
  </p>
  <p>
The photos and videos will be featured on the UKFN website and YouTube channel. The winners will also have the opportunity to describe the background research in an article on the UKFN website.
  </p>

  <p><b>Voting is now open.</b></p>

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
