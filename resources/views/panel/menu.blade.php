<nav class="admin-panel-sidebar" id="admin-side-bar">
    <div class="navbar-header nopadding">
        <button type="button" class="navbar-toggle btn btn-block" data-toggle="collapse" data-target="#adminnav" id="admin-nav-mobile">
            Panel Menu
        </button>
    </div>
    <ul id="adminnav" class="nav nav-stacked fixed collapse navbar-collapse"> 
        <li class="{{ Request::is('panel') ? 'active' : '' }}">
            <a class="{{ Request::is('panel') ? 'active' : '' }}" href="{{URL::to('/panel')}}">Panel</a>
        </li>
        
        <li class="{{ Request::is('panel/tags*') ? 'active' : '' }}">
            <a href="{{ URL::to('panel/tags') }}" class="{{ Request::is('panel/tags*') ? 'active' : '' }}">Tags</a>
            <ul id="admin-subnav-tags" class="nav nav-stacked">
                <li><a href="{{ URL::to('panel/tags/disciplines') }}" class="{{ Request::is('panel/tags/disciplines') ? 'active' : '' }}">Fluids sub-disciplines</a></li>
                <li><a href="{{ URL::to('panel/tags/applications') }}" class="{{ Request::is('panel/tags/applications') ? 'active' : '' }}">Application areas</a></li>
                <li><a href="{{ URL::to('panel/tags/techniques') }}" class="{{ Request::is('panel/tags/techniques') ? 'active' : '' }}">Techniques</a></li>
                <li><a href="{{ URL::to('panel/tags/facilities') }}" class="{{ Request::is('panel/tags/facilities') ? 'active' : '' }}">Facilities</a></li>
                <li><a href="{{ URL::to('panel/tags/add') }}" class="{{ Request::is('panel/tags/add') ? 'active' : '' }}">Add</a></li>
            </ul>
        </li>

        <li class="{{ Request::is('panel/users*') ? 'active' : '' }}">
            <a href="{{ URL::to('panel/users') }}" class="{{ Request::is('panel/users*') ? 'active' : '' }}">Users</a>
            <ul id='admin-subnav-users' class='nav nav-stacked'>
                <li><a href="{{ URL::to('panel/users/add') }}" class="{{ Request::is('panel/users/add') ? 'active' : '' }}">Add</a></li>
            </ul>
        </li>

        <li class="{{ Request::is('panel/institutions*') ? 'active' : '' }}">
            <a href="{{ URL::to('panel/institutions')}}" class="{{ Request::is('panel/institutions*') ? 'active' : '' }}">Institutions</a>
            <ul id='admin-subnav-institutions' class='nav nav-stacked'>
                <li><a href="{{ URL::to('panel/institutions/add')}}" class="{{ Request::is('panel/institutions/add') ? 'active' : '' }}">Add</a></li>
            </ul>
        </li>

        <li class="{{ Request::is('panel/sig*') || Request::is('panel/suggestions*') ? 'active' : '' }}">
            <a href="{{ URL::to('panel/sig') }}" class="{{ Request::is('panel/sig*') || Request::is('panel/suggestions*') ? 'active' : '' }}">SIG</a>
            <ul id='admin-subnav-sig' class='nav nav-stacked'>
                <li><a href="{{ URL::to('panel/suggestions') }}" class="{{ Request::is('panel/suggestions') ? 'active' : '' }}">Suggestions</a></li>
                <li><a href="{{ URL::to('panel/sig/add') }}" class="{{ Request::is('panel/sig/add') ? 'active' : '' }}">Add</a></li>
            </ul>
        </li>

        <li class="{{ Request::is('panel/news*') ? 'active' : '' }}">
            <a href="{{ URL::to('panel/news') }}" class="{{ Request::is('panel/news*') ? 'active' : '' }}">News</a>
            <ul id='admin-subnav-news' class='nav nav-stacked'>
                <li><a href="{{ URL::to('panel/news/add') }}" class="{{ Request::is('panel/news/add') ? 'active' : '' }}">Add</a></li>
            </ul>
        </li>

        <li class="{{ Request::is('panel/events*') ? 'active' : '' }}">
            <a href="{{ URL::to('panel/events') }}" class="{{ Request::is('panel/events*') ? 'active' : '' }}">Events</a>
            <ul id='admin-subnav-events' class='nav nav-stacked'>
                <li><a href="{{ URL::to('panel/events/add') }}" class="{{ Request::is('panel/events/add') ? 'active' : '' }}">Add</a></li>
            </ul>
        </li>

        <li class="{{ Request::is('panel/titles*') ? 'active' : '' }}">
            <a href="{{ URL::to('panel/titles') }}" class="{{ Request::is('panel/titles*') ? 'active' : '' }}">Titles</a>
            <ul id='admin-subnav-titles' class='nav nav-stacked'>
                <li><a href="{{ URL::to('panel/titles/add') }}" class="{{ Request::is('panel/titles/add') ? 'active' : '' }}">Add</a>
            </ul>
        </li>
        
        <li class="{{ Request::is('panel/talks*') ? 'active' : '' }}">
            <a href="{{ URL::to('panel/talks') }}" class="{{ Request::is('panel/talks*') ? 'active' : '' }}">Talks</a>
            <ul id='admin-subnav-talks' class='nav nav-stacked' >
                <li><a href="{{ URL::to('/panel/talks/add') }}" class="{{ Request::is('panel/talks/add') ? 'active' : '' }}">Add talk</a></li>
                <li><a href="{{ URL::to('/panel/talks/feeds') }}" class="{{ Request::is('panel/talks/feeds') ? 'active' : '' }}">RSS feeds</a></li>
                <li><a href="{{ URL::to('/panel/talks/feeds/add') }}" class="{{ Request::is('panel/talks/feeds/add') ? 'active' : '' }}">Add RSS feed</a></li>
            </ul>
        </li>
        
        <li class="{{ Request::is('panel/sendmail*', 'panel/subscriptions*', 'panel/messages*') ? 'active' : '' }}">
            <a href="{{ URL::to('panel/messages') }}" class="
               {{ Request::is('panel/sendmail*', 'panel/subscriptions*', 'panel/messages*') ? 'active' : '' }}">Mailing</a>
            <ul id='admin-subnav-mailing' class='nav nav-stacked' >
                <li><a href="{{ URL::to('panel/sendmail') }}" class="{{ Request::is('panel/sendmail') ? 'active' : '' }}">Send Mail</a></li>
                <li><a href="{{ URL::to('panel/subscriptions') }}" class="{{ Request::is('panel/subscriptions') ? 'active' : '' }}">Subscriptions</a></li>
            </ul>
        </li>
    </ul> 
</nav>