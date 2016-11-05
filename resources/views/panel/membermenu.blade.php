<div id='adminnav' class='list-group'>    
    <div>
        <a class="panel-title list-group-item noborderradius {{ Request::is('myaccount') ? 'active' : '' }}" href="{{URL::to('/myaccount')}}">My Account</a>
    </div>
    <div>
        <a class="panel-title list-group-item noborderradius {{ Request::is('changepassword') ? 'active' : '' }}" href="{{URL::to('/changepassowrd')}}">Change Password</a>
    </div>
</div>    
