<div class="app-bar fixed-top bg-darker" data-role="appbar">
    <div class="container-top">
        <div class="sidebar-trigger sidebar-sizer mobile-only"><span class="fa fa-gear"></span></div>
        @include('partials.navbar.logo')
        <ul class="app-bar-menu place-right">
            @if (Auth::guest())
            @include('partials.header.guest_link')
            @else
            @include('partials.header.notification_latest')
            @include('partials.header.rtl')
            @include('partials.header.user_profile')
            @endif
        </ul>
    </div>
</div>