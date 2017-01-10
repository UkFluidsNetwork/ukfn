<div id='adminnav' class='list-group'>    
    <div>
        <a class="panel-title list-group-item noborderradius {{ Request::is('panel') ? 'active' : '' }}" href="{{URL::to('/panel')}}">Panel</a>
    </div>

    <div>
        <a href="{{ URL::to('#admin-subnav-tags') }}" data-parent="#adminnav" data-toggle="collapse"
           class="panel-title list-group-item noborderradius {{ Request::is('panel/tags*') ? 'active' : '' }}">Tags</a>
        <div id='admin-subnav-tags' class='collapse list-group' >
            {{ Html::link('panel/tags', 'All tags', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/tags/disciplines', 'Fluids sub-disciplines', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/tags/applications', 'Application areas', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/tags/techniques', 'Techniques', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/tags/facilities', 'Facilities', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/tags/add', 'Add', ['class' => 'list-group-item noborder']) }}
        </div>
    </div>

    <div>
        <a href="{{ URL::to('#admin-subnav-users') }}" data-parent="#adminnav" data-toggle="collapse"
           class="panel-title list-group-item noborderradius {{ Request::is('panel/users*') ? 'active' : '' }}">Users</a>
        <div id='admin-subnav-users' class='collapse list-group' >
            {{ Html::link('panel/users', 'List', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/users/add', 'Add', ['class' => 'list-group-item noborder']) }}
        </div>
    </div>

    <div>
        <a href="{{ URL::to('#admin-subnav-institutions') }}" data-parent="#adminnav" data-toggle="collapse"
           class="panel-title list-group-item noborderradius {{ Request::is('panel/institutions*') ? 'active' : '' }}">Institutions</a>
        <div id='admin-subnav-institutions' class='collapse list-group' >
            {{ Html::link('panel/institutions', 'List', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/institutions/add', 'Add', ['class' => 'list-group-item noborder']) }}
        </div>
    </div>

    <div>
        <a href="{{ URL::to('#admin-subnav-sig') }}" data-parent="#adminnav" data-toggle="collapse"
           class="panel-title list-group-item noborderradius {{ Request::is('panel/sig*') || Request::is('panel/suggestions*') ? 'active' : '' }}">SIG</a>
        <div id='admin-subnav-sig' class='collapse list-group' >
            {{ Html::link('panel/sig', 'List', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/suggestions', 'Suggestions', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/sig/add', 'Add', ['class' => 'list-group-item noborder']) }}
        </div>
    </div>

    <div>
        <a href="{{ URL::to('#admin-subnav-news') }}" data-parent="#adminnav" data-toggle="collapse"
           class="panel-title list-group-item noborderradius {{ Request::is('panel/news*') ? 'active' : '' }}">News</a>
        <div id='admin-subnav-news' class='collapse list-group' >
            {{ Html::link('panel/news', 'List', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/news/add', 'Add', ['class' => 'list-group-item noborder']) }}
        </div>
    </div>

    <div>
        <a href="{{ URL::to('#admin-subnav-events') }}" data-parent="#adminnav" data-toggle="collapse"
           class="panel-title list-group-item noborderradius {{ Request::is('panel/events*') ? 'active' : '' }}">Events</a>
        <div id='admin-subnav-events' class='collapse list-group' >
            {{ Html::link('panel/events', 'List', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/events/add', 'Add', ['class' => 'list-group-item noborder']) }}
        </div>
    </div>

    <div>
        <a href="{{ URL::to('#admin-subnav-titles') }}" data-parent="#adminnav" data-toggle="collapse"
           class="panel-title list-group-item noborderradius {{ Request::is('panel/titles*') ? 'active' : '' }}">Titles</a>
        <div id='admin-subnav-titles' class='collapse list-group' >
            {{ Html::link('panel/titles', 'List', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/titles/add', 'Add', ['class' => 'list-group-item noborder']) }}
        </div>
    </div>
    
    <div>
        <a href="{{ URL::to('#admin-subnav-talks') }}" data-parent="#adminnav" data-toggle="collapse"
            class="panel-title list-group-item noborderradius {{ Request::is('edittalks*', 'talksarchive*') ? 'active' : '' }}">Talks</a>
        <div id='admin-subnav-talks' class='collapse list-group' >
            {{ Html::link('/panel/talks', 'View Talks', ['class' => 'list-group-item noborder']) }}
        </div>
    </div>
    

    <div>
        <a href="{{ URL::to('#admin-subnav-mailing') }}" data-parent="#adminnav" data-toggle="collapse"
           class="panel-title list-group-item noborderradius 
           {{ Request::is('panel/sendmail*', 'panel/subscriptions*', 'panel/messages*') ? 'active' : '' }}">Mailing</a>
        <div id='admin-subnav-mailing' class='collapse list-group' >
            {{ Html::link('panel/sendmail', 'Send Mail', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/subscriptions', 'Subscriptions', ['class' => 'list-group-item noborder']) }}
            {{ Html::link('panel/messages', 'View Messages', ['class' => 'list-group-item noborder']) }}
        </div>
    </div>
</div>    
