<div class="app-bar fixed-top bg-darker" data-role="appbar">
    <div class="container-top">
        <div class="sidebar-trigger sidebar-sizer mobile-only"><span class="fa fa-menu"></span></div>
        @include('modules.evolutly.partials.navbar.logo')
        <ul class="app-bar-menu place-right">
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="#!" data-role="hint" data-hint="Need Help?" data-hint-background="bg-darkTeal" data-hint-color="fg-white">&nbsp;<span class="mif-help fg-orange"></span> Support</a>
            </li>
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="{{route('employee.login')}}" data-role="hint" data-hint="Are You Part of Team?" data-hint-background="bg-darkTeal"
                    data-hint-color="fg-white">&nbsp;<span class="mif-enter fg-lime"></span>  Team Login</a>
            </li>
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="{{route('client.login')}}" data-role="hint" data-hint="Are You a Client?" data-hint-background="bg-darkTeal"
                    data-hint-color="fg-white">&nbsp;<span class="mif-user-plus fg-teal "></span>  Client Login</a>
            </li>
        </ul>
    </div>
</div>