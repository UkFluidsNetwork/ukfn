<div id='adminnav' class='list-group'>    
  <div>
    <a class="panel-title list-group-item noborderradius {{ Request::is('admin') ? 'active' : '' }}" href="{{URL::to('/panel')}}">Panel</a>          
  </div>

  <div>
    <a href="{{ URL::to('#admin-subnav-sig') }}" data-parent="#adminnav" data-toggle="collapse"
       class="panel-title list-group-item noborderradius {{ Request::is('suggestions*') ? 'active' : '' }}">SIG</a>
    <div id='admin-subnav-sig' class='collapse list-group' >
      {{ Html::link('/suggestions', 'Suggestions', ['class' => 'list-group-item noborder']) }}
    </div>
  </div>

  <div>
    <a href="{{ URL::to('#admin-subnav-mailing') }}" data-parent="#adminnav" data-toggle="collapse"
       class="panel-title list-group-item noborderradius {{ Request::is('sendmail*', 'subscriptions*', 'messages*') ? 'active' : '' }}">Mailing</a>
    <div id='admin-subnav-mailing' class='collapse list-group' >
      {{ Html::link('/sendmail', 'Send Mail', ['class' => 'list-group-item noborder']) }}
        {{ Html::link('/subscriptions', 'Subscriptions', ['class' => 'list-group-item noborder']) }}
      
      {{ Html::link('/messages', 'View Mesasges', ['class' => 'list-group-item noborder']) }}
    </div>
  </div>
</div>    
