@if($guard === 'employee')
<!-- Dashboard Menu-->
<li class="{{ (Request::segment(2)=='dashboard'?'active-container':'') }}">

    <a href="#" class="dropdown-toggle">
			<span class="mif-apps icon fg-steel"></span>
			<span class="title fg-amber">Dashboard</span>
			<span class="counter">Manage App</span>
	</a>
    <!-- Projects Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='dashboard'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='dashboard'?'active':'') }}">
            <a href="{{ route('employee.dashboard') }}">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Clients</span>
                <span class="counter">Manage Projects</span>
			</a>
        </li>
    </ul>
</li>
<!-- Profile Menu -->
<li class="{{ (Request::segment(2)=='profile'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-profile icon fg-lime"></span>
            <span class="title fg-amber">Account Settings</span>
            <span class="counter">Manage Account</span>
    </a>
    <!-- Profile Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='profile'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='profile'?'active':'') }}">
            <a href="{{ route('employee.profile') }}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Profile</span>
                    <span class="counter">Manage Profile</span>
            </a>
        </li>
    </ul>
</li>
<!-- Security -->
<li class="{{ (Request::segment(2)=='password'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-lock icon fg-yellow"></span>
            <span class="title fg-amber">Security</span>
            <span class="counter">Secure Your Account</span>
    </a>
    <!-- Password Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='password'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='password'?'active':'') }}">
            <a href="{{ route('employee.password') }}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Password</span>
                    <span class="counter">Change Password</span>
            </a>
        </li>
    </ul>
</li>
@include('evolutly::partials.sidebar.company_menu')
@elseif($guard === 'client')
<!-- Dashboard Menu -->
<li class="{{ (Request::segment(2)=='dashboard'?'active-container':'') }}">

    <a href="#" class="dropdown-toggle">
			<span class="mif-apps icon fg-steel"></span>
			<span class="title fg-amber">Dashboard</span>
			<span class="counter">Manage App</span>
	</a>
    <!-- Projects Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='dashboard'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='dashboard'?'active':'') }}">
            <a href="{{ route('client.dashboard') }}">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Project</span>
                <span class="counter">Manage Projects</span>
			</a>
        </li>
    </ul>
</li>
<!-- Profile Menu -->
<li class="{{ (Request::segment(2)=='profile'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-profile icon fg-lime"></span>
            <span class="title fg-amber">Account Settings</span>
            <span class="counter">Manage Account</span>
    </a>
    <!-- Profile Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='profile'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='profile'?'active':'') }}">
            <a href="{{ route('client.profile') }}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Profile</span>
                    <span class="counter">Manage Profile</span>
            </a>
        </li>
    </ul>
</li>
<!-- Security -->
<li class="{{ (Request::segment(2)=='password'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-lock icon fg-yellow"></span>
            <span class="title fg-amber">Security</span>
            <span class="counter">Secure Your Account</span>
    </a>
    <!-- Password Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='password'?'display:block':'') }}">
        <li class="{{ (Request::segment(2)=='password'?'active':'') }}">
            <a href="{{ route('client.password') }}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Password</span>
                    <span class="counter">Change Password</span>
            </a>
        </li>
    </ul>
</li>
@else
<!-- Dashboard Menu -->
<li class="{{ (Request::segment(1)=='dashboard'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
			<span class="mif-apps icon fg-steel"></span>
			<span class="title fg-amber">Dashboard</span>
			<span class="counter">Manage App</span>
    </a>
    <!-- Projects Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(1)=='dashboard'?'display:block':'') }}">
        <li class="{{ (Request::segment(1)=='dashboard'?'active':'') }}">
            <a href="/dashboard">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Clients</span>
                <span class="counter">Manage Projects</span>
			</a>
        </li>
    </ul>
</li>
<!-- Templates Menu -->
<li class="{{ (Request::segment(1)=='templates'?'active-container':'') }}">
        <a href="#" class="dropdown-toggle">
                <span class="mif-stack3 icon fg-steel"></span>
                <span class="title fg-amber">Templates</span>
                <span class="counter">Manage Templates</span>
        </a>
        <!-- Projects Link -->
        <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(1)=='templates'?'display:block':'') }}">
            <li class="{{ (Request::segment(1)=='templates'?'active':'') }}">
                <a href="/templates">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Pre-Built Templates</span>
                    <span class="counter">Clone Template For Clients</span>
                </a>
            </li>
            <li>
                <a href="/dashboard">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Add Templates</span>
                    <span class="counter">Clone an Existing Client</span>
                </a>
            </li>
        </ul>
    </li>
<!-- Profile Menu -->
<li class="">
    <a href="#" class="dropdown-toggle">
            <span class="mif-profile icon fg-lime"></span>
            <span class="title fg-amber">Account Settings</span>
            <span class="counter">Manage Account</span>
    </a>
    <!-- Profile Link -->
    <ul class="d-menu" data-role="dropdown" style="">
        <li class="">
            <a href="{{ url('/settings#/profile') }}" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Profile</span>
                <span class="counter">Manage Profile</span>
            </a>
        </li>
    </ul>
</li>
<!-- Users Menu Link -->
<li class="{{ (Request::segment(1)=='users'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
            <span class="mif-users icon fg-olive"></span>
            <span class="title fg-amber">User Management</span>
            <span class="counter">Manage Users</span>
    </a>
    <ul class="d-menu" data-role="dropdown" style="{{ (in_array(Request::segment(2),['teammates','clients'])?'display:block':'') }}">
        <!-- Employee -->
        @if(Auth::user()->isSuperAdmin())
        <li class="{{ (Request::segment(1)=='users'?'active':'') }}">
                <a href="{{url('/users')}}" class="">
                        <span class="mif-chevron-right icon"></span>
                        <span class="title">Tenants</span>
                        <span class="counter">Manage Tenants Account</span>
                    </a>
        </li>
        @endif
        <!-- Employee -->
        <li class="{{ (Request::segment(2)=='teammates'?'active':'') }}">
            <a href="{{url('/users/teammates')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Teammates</span>
                    <span class="counter">Manage Teams Account</span>
                </a>
        </li>
        <!-- Client -->
        <li class="{{ (Request::segment(2)=='clients'?'active':'') }}">
            <a href="{{url('/users/clients')}}" class="">
                    <span class="mif-chevron-right icon"></span>
                    <span class="title">Clients</span>
                    <span class="counter">Manage Clients Account</span>
            </a>
        </li>
    </ul>
</li>
{{-- @include('evolutly::partials.sidebar.file_menu') --}}
{{-- @include('evolutly::partials.sidebar.company_menu') --}}
@endif
<!-- Support Menu -->
<!-- <li>
    <a href="#support" class="">
        <span class="mif-help icon fg-darkOrange"></span>
        <span class="title fg-amber">Help</span>
        <span class="counter">Ask Support</span>
	</a>
</li> -->
<!-- Toggle Sidebar menu -->
<li>
    <a class="sidebar-sizer">
        <span class="mif-tab icon fg-grayLighter mif-ani-horizontal mif-ani-slow " ></span>
        <span class="title" >Collapse Sidebar</span>
        <span class="counter" >Toggle Sidebar</span>
	</a>
</li>