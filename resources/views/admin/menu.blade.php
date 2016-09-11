<div id='adminnav' class='list-group'>    
  <div>
    <a class="panel-title list-group-item noborderradius {{ Request::is('admin') ? 'active' : '' }}" href="{{URL::to('/admin')}}">Admin</a>          
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
       class="panel-title list-group-item noborderradius {{ Request::is('subscriptions*') ? 'active' : '' }}">Mailing List</a>
    <div id='admin-subnav-mailing' class='collapse list-group' >
      {{ Html::link('/subscriptions', 'Subscriptions', ['class' => 'list-group-item noborder']) }}
    </div>
  </div>
</div>    
