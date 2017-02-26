<nav class="admin-panel-sidebar" id="admin-side-bar">
    <div class="navbar-header nopadding">
        <button type="button" class="navbar-toggle btn btn-block" data-toggle="collapse" data-target="#adminnav" id="admin-nav-mobile">
            Menu
        </button>
    </div>
    <ul id="adminnav" class="nav nav-stacked fixed collapse navbar-collapse"> 
        <li class="{{ Request::is('panel/tags*') ? 'active' : '' }}">
            <a href="{{URL::to('/panel/sig/edit/' . Auth::user()->sigLeader()[0])}}" class="{{ Request::is('panel/tags*') ? 'active' : '' }}">Manage SIG</a>
            <ul id="admin-subnav-tags" class="nav nav-stacked">
                <li><a href="/panel/sig/addmembers/{{ Auth::user()->sigLeader()[0] }}" class="{{ Request::is('panel/tags/disciplines') ? 'active' : '' }}">Add Members</a></li>
            </ul>
        </li>
    </ul>
</nav>