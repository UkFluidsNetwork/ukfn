        @if (Session::has('success_message'))

          <div class='alert alert-success line-break-dbl'>
            <button type='button' class='close' data-dismiss='alert' aria-hiden='true'>&times;</button>
            <strong class='display-block'>
              {{ Session::get('success_message') }}
            </strong>
          </div>

        @endif