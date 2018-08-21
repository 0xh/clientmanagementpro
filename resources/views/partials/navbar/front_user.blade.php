<div class="app-bar fixed-top bg-darker" data-role="appbar">
    <div class="container-top">
        <div class="sidebar-trigger sidebar-sizer mobile-only"><span class="fa fa-menu"></span></div>
         @include('partials.navbar.logo')
        <ul class="app-bar-menu place-right">
            @include('partials.header.notification_latest')
            <li class="bg-darker ">
                <a href="#" class="dropdown-toggle">
                    <img src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}"
                    style="border: 2px solid #d3e0e9;
                    border-radius: 50%;
                    height: 40px;
                    padding: 2px;
                    width: 40px;
                    height: 50px;
                    width: 50px;">
                    {{ auth()->user()->name }}</a>
                <ul class="d-menu context place-right" data-role="dropdown">
                    <li><a href="{{url('/dashboard')}}"><span class="mif-windows icon" ></span> Dashboard</a></li>
                    <li><a href="{{url('/')}}"><span class="mif-home icon" ></span>Front End</a></li>
                    <li class="divider"></li>
                    <li class="">
                        <a href="#" class="dropdown-toggle"><span class="fa fa-users icon " ></span>Teams</a>
                        <ul class="d-menu context drop-left" data-role="dropdown">
                            <li><a href="/settings#/teams" class="active-lang"><span class="mif-user-plus fg-green icon" ></span> Create Team</a></li>
                            <li><a href="#"><span class="icon" ></span> List All Your teams Here</a></li>
                        </ul>
                    </li>

                    <li><a href="/settings#/profile"><span class="mif-user icon" ></span> Profile</a></li>
                    <li><a href="/logout"><span class="mif-exit icon" ></span> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>