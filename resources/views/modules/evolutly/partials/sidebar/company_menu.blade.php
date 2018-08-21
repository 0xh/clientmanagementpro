<!-- Tutorial Menu -->
<li class="{{ (Request::segment(2)=='chart'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
        <span class="mif-school icon fg-lighterBlue"></span>
        <span class="title fg-amber">Tutorial</span>
        <span class="counter">Watch Video</span>
	</a>
    <!-- Tutorial Link -->
    <ul class="d-menu" data-role="dropdown" style="{{ (Request::segment(2)=='chart'?'display:block':'') }}">
        <li class="{{ (Request::segment(3)=='getting-started'?'active':'') }}">
            <a href="{{url('#')}}" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Getting Started</span>
                <span class="counter">How To Get Started</span>
			</a>
        </li>
    </ul>
</li>
<!-- Company Menu -->
<li class="">
    <a href="#" class="dropdown-toggle">
        <span class="mif-info icon fg-lightTeal"></span>
        <span class="title fg-amber">News</span>
        <span class="counter">Latest Updates</span>
	</a>
    <ul class="d-menu" data-role="dropdown">
        <!-- Change Log Link -->
        <li>
            <a href="{{url('#')}}" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Change Log</span>
                <span class="counter">Read Changes On App</span>
			</a>
        </li>
    </ul>
</li>