          @if ($errors->any())
          
          <div class='alert alert-danger errrors line-break-dbl'>  
            <strong>
              <span class='glyphicon glyphicon-exclamation-sign line-break'></span> Please correct these errors
            </strong>
            <ul class="list-unstyled">
              @foreach ($errors->all() as $error)
              
              <li> - {{ $error }}</li>
              @endforeach
              
            </ul>
          </div>

          @endif