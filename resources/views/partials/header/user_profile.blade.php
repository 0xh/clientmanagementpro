<li class="bg-darker ">
    <a href="#" class="dropdown-toggle">
        <img src="{{ auth()->user()->photo_url }}" 
            alt="{{ auth()->user()->name }}"
            style="border: 2px solid #d3e0e9;
                    border-radius: 50%;
                    height: 40px;
                    padding: 2px;
                    width: 40px;
                    height: 50px;
                    width: 50px;"
        >
        {{ auth()->user()->name }}
    </a>
    <ul class="d-menu context place-right" data-role="dropdown">
        <li><a href="{{url('/home')}}"><span class="mif-windows icon" ></span>Dashboard</a></li>
        <li><a href="{{url('/')}}"><span class="mif-home icon" ></span>Front Page</a></li>
        <li class="divider"></li>
        <li><a href="/settings#/profile"><span class="mif-user icon" ></span> Profile</a></li>
        <li><a href="/logout"><span class="mif-exit icon" ></span> Logout</a>
        </li>
    </ul>
</li>