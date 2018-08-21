<div class="app-bar fixed-top bg-darker" data-role="appbar">
    <div class="container-top">
        <div class="sidebar-trigger sidebar-sizer mobile-only"><span class="fa fa-menu"></span></div>
         @include('modules.evolutly.partials.navbar.logo')
        <ul class="app-bar-menu place-right">
        <li class="bg-darker ">
            <a href="#!" class="dropdown-toggle">
                    <img src="{{ auth()->guard($guard)->user()->photo_url }}" alt="{{ auth()->guard($guard)->user()->name }}"
                    style="border: 2px solid #d3e0e9;
                    border-radius: 50%;
                    height: 40px;
                    padding: 2px;
                    width: 40px;
                    height: 50px;
                    width: 50px;">
                    {{ auth()->guard($guard)->user()->name }}</a>
            <ul class="d-menu context place-right" data-role="dropdown">
        @if($guard === 'employee')
        </li>
        </ul>
        <li><a href="{{route('employee.dashboard')}}"><span class="mif-windows icon" ></span> Dashboard</a></li>
        <li><a href="{{url(config('app.url'))}}"><span class="mif-home icon" ></span>Front End</a></li>
        <li class="divider"></li>
        <li><a href="{{route('employee.logout')}}"><span class="mif-exit icon" ></span> Logout</a>
                
        
        @elseif($guard === 'client')
        </li>
        </ul>
        <li><a href="{{route('client.dashboard')}}"><span class="mif-windows icon" ></span> Dashboard</a></li>
        <li><a href="{{url(config('app.url'))}}"><span class="mif-home icon" ></span>Front End</a></li>
        <li class="divider"></li>
        <li><a href="{{route('client.logout')}}"><span class="mif-exit icon" ></span> Logout</a>
        @else
        </li>
        </ul>
        <li><a href="{{route('dashboard')}}"><span class="mif-windows icon" ></span> Dashboard</a></li>
        <li><a href="{{route('frontend')}}"><span class="mif-home icon" ></span>Front End</a></li>
        <li class="divider"></li>
        <li><a href="/settings#/profile"><span class="mif-user icon" ></span> Profile</a></li>
        <li><a href="/logout"><span class="mif-exit icon" ></span> Logout</a>
        </li>
        @endif
    </div>
</div>