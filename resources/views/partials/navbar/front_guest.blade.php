<div class="app-bar fixed-top bg-darker" data-role="appbar">
    <div class="container-top">
        <div class="sidebar-trigger sidebar-sizer mobile-only"><span class="fa fa-menu"></span></div>
        @include('partials.navbar.logo')
        <ul class="app-bar-menu place-right">
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="#!" data-role="hint" data-hint="Need Help?" data-hint-background="bg-darkTeal" data-hint-color="fg-white">&nbsp;<span class="mif-help fg-orange"></span> Support</a>
            </li>
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="{{ route('client.login') }}" data-role="hint" data-hint="Are You A Client?" data-hint-background="bg-darkTeal"
                    data-hint-color="fg-white">&nbsp;<span class="fa fa-user-secret fg-lime"></span>  Client</a>
            </li>
            <li class="bg-darker">
                <a class="icon bg-hover-red" href="{{ route('employee.login') }}" data-role="hint" data-hint="Are You Part Of A Team?" data-hint-background="bg-darkTeal"
                    data-hint-color="fg-white">&nbsp;<span class="fa fa-suitcase fg-red"></span>  Team Member</a>
            </li>
        </ul>
    </div>
</div>