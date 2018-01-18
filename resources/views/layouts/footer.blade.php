<footer id="colophon" class="site-footer" role="contentinfo">
  <div class="footer-connect">
    <div class="container">
      <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
          <!-- NEWSLETTER CODE -->
            <div class="footer-subscribe" id="subscription-sign-up-form">
              <h3 class="follow-heading">Sign up to our mailing list</h3>
              {!! Form::open(['url' => 'signup#subscription-sign-up-form']) !!}
              <div class='form-group {{ $errors->has('subscription-email') ? ' has-error line-break-dbl' : '' }} input-group-lg'>
                {!! Form::label('subscription-email',
                                'Subscribe :', ['class' => 'sr-only']) !!}
                {!! Form::text('subscription-email', null,
                                ['class' => 'form-control',
                                 'placeholder' => 'your@email.com']) !!}
                @if ($errors->has('subscription-email'))
                  <span class="display-block red-link bold line-break-top">
                    <span>{{ $errors->first('subscription-email') }}</span>
                  </span>
                @endif
                @if (Session::has('subscription_signup_ok'))
                   <strong class="display-block text-success line-break-top">
                       {{ Session::get('subscription_signup_ok') }}
                   </strong>
                @endif
              </div>
              <div>
                  <label class="switch margin-right">
                      <input type="checkbox" name="human" value="human">
                      @if ($errors->has('human'))
                      <span class="slider round error"></span>
                      @else
                      <span class="slider round"></span>
                      @endif
                  </label>
                  @if ($errors->has('human'))
                  <span class="switch-label red-link">
                      Click to prove you are human
                  </span>
                  @else
                  <span class="switch-label">
                      Click to prove you are human
                  </span>
                  @endif
              </div>
              <div>
                  <input id="subscription-submit"
                         type="submit"
                         class="btn btn-lg btn-primary line-break-top"
                         name="submit-subscribe"
                         value="Subscribe">
              </div>
              {!! Form::close() !!}
            </div>
        </div>
        <div class="col-sm-4">
              <div class="footer-social">
                  <h3 class="follow-heading">Follow us</h3>
                  <div class="footer-social-icons">
                      <a target="_blank"
                         href="https://www.facebook.com/UKFluids/"
                         title="Facebook">
                          <i class="fa fa fa-facebook"></i></a>
                      <a target="_blank"
                         href="https://www.youtube.com/channel/UCS63du5FONb5ICQUX_kcXTw"
                         title="YouTube">
                          <i class="fa fa fa-youtube"></i></a>
                      <a target="_blank"
                         href="https://github.com/ukfluidsnetwork"
                         title="GitHub">
                          <i class="fa fa fa-github"></i></a>
                      <a target="_blank" href="https://twitter.com/UKFluidsNetwork"
                         title="Twitter">
                          <i class="fa fa fa-twitter"></i></a>
                  </div>
              </div>
          </div>
          <div class="col-sm-2"></div>
      </div>
    </div>
  </div>
  <div class="site-info">
        <div class="container">
            <div class="btt">
                <a class="back-top-top" id="back-top"
                   onclick="backToTop()" title="Back To Top">
                    <i class="glyphicon glyphicon-chevron-up wow flash"
                       data-wow-duration="2s"></i>
                </a>
            </div>
            <div class="row footer-cc-eu-icons">
                <div class="col-sm-6">
                    <a rel="license"
                       href="http://creativecommons.org/licenses/by/4.0/">
                        <img alt="Creative Commons License"
                             style="border-width:0; margin-top: 1em; margin-bottom: 1.5em;"
                             src="/pictures/CC-BY_icon.svg.png" />
                    </a>
                    <br>
                    Unless otherwise indicated, all materials created by the UK Fluids Network are licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.
                </div>
                <div class="col-sm-6">
                    <a href="https://www.epsrc.ac.uk/">
                        <img src="/pictures/epsrc.png" style="margin-bottom: 1em;" height="60px" width="auto" />
                    </a>
                    <br>
                    This project has received funding from the <a href="https://www.epsrc.ac.uk/">Engineering and Physical Sciences Research Council</a> under grant agreement EP/N032861/1.
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <a href="https://github.com/UkFluidsNetwork/ukfn" class="footer-color" target="_blank"><i class="fa fa-github" aria-hidden="true"></i> Source code</a> available under the MIT license - developed by <a href="https://arias.re" class="footer-color" target="_blank">Javier Arias</a>.
                </div>
            </div>
        </div>
    </div>
</footer>
