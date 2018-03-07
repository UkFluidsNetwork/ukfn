<nav class="admin-panel-sidebar" id="admin-side-bar">
    <div class="navbar-header nopadding">
        <button type="button" class="navbar-toggle btn btn-block"
                data-toggle="collapse" data-target="#adminnav"
                id="admin-nav-mobile">
            Menu
        </button>
    </div>
    <ul id="adminnav" class="nav nav-stacked fixed collapse navbar-collapse">
        <li class="{{ Request::is('panel/sig*') ? 'active' : '' }}">
            @foreach (Auth::user()->editableSigs() as $sig)
            <a href="{{URL::to('/panel/sig/edit/' . $sig->id)}}"
               class="{{ Request::is('panel/sig/edit/' . $sig->id)
                         ? 'active' : '' }}">
               {{$sig->shortname}}
            </a>

            <ul id="admin-subnav-tags" class="nav nav-stacked">
                <li>
                    <a href="{{URL::to('/panel/sig/members/' . $sig->id)}}"
                       class="{{ Request::is('panel/sig/members/' . $sig->id)
                                 ? 'active' : '' }}">
                       Members
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('/panel/sig/box/' . $sig->id)}}"
                       class="{{ Request::is('panel/sig/box/' . $sig->id)
                                 ? 'active' : '' }}">
                       Edit Page
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('/panel/sig/files/'.$sig->id)}}"
                       class="{{Request::is('panel/sig/files/'.$sig->id)
                                 ? 'active' : '' }}">
                       Files
                    </a>
                </li>
            </ul>
            @endforeach
        </li>
    </ul>
</nav>
