@extends('layouts.marketing_page') 
@section('content')
<!-- Navigation -->
<nav class="nav-wrp nav-3" data-sticky="y">
    <div class="container">
        
        <div class="nav-header" style="padding:10px">
            <a class="navbar-brand" href="#"><img src="/images/logo.png" alt="Brand logo" style="display: block; margin:0 auto;text-align: left;"></a>
			<a class="nav-handle" data-nav=".nav"><i class="fa fa-bars"></i></a>
			
        </div>
        
        <div class="nav vm-item">
                <ul class="nav-links sf-menu">
                @if(Auth::guest() || Auth::guest('employee') || Auth::guest('client') )
                <li><a class="icon" href="{{ route('login') }}">Login</a></li>
                <li><a class="icon" href="{{ route('register') }}">Register</a></li>
                @else
                <li><a href="{{url('/dashboard')}}">Dashboard</a></li>
                <li><a href="/settings#/profile">Profile</a></li>
                <li><a href="/logout">Logout</a></li>
                <li><a href="{{url('/home')}}">Home</a></li>
                @endif	
                </ul>
        </div><!-- /.nav --> 
        
    </div><!-- /.container --> 
</nav><!-- /.nav-wrp -->


<!-- Intro -->
<section class="intro-section intro-section-5">
    <div class="container">

        <div class="info-wrp">
            <h2 class="main-text">Onboard Clients & Manage Your Digital Agency Tasks without Stress</h2>
            <p class="sub-text">Finally a solution created for Marketing Agencies BY Marketing Experts</p>
            </br>
            <img src="images/screen-img1.png" alt="App image" class="img-responsive">
        </div>
    
    </div><!-- /.container -->
    <div class="bg-section bg-cover bg-cc full-wh" data-bg="/images/bg7.jpg"><b class="full-wh"></b></div>
</section><!-- /.intro-section -->


<!-- Slider -->
<section class="slider-section slider-section-4">
    <div class="container">
        <div class="carousel-widget ctrl-1" 
            data-items="1"
            data-itemrange="false"
            data-tdrag="false"
            data-mdrag="false"
            data-pdrag="false"
            data-autoplay="true" 
            data-loop="true"
            data-nav="false">

            <div class="owl-carousel">
                
                

                <div class="item">
                    <p class="content">
                        Quick and easy way to manage data
                        
                    </p>
                </div><!-- /.item -->

            </div><!-- /.owl-carousel -->
        </div><!-- /.carousel-widget -->
    </div>
</section><!-- /.slider-section -->


<!-- Features -->
<section id="feature" class="feature-section feature-section-2 pd-tb-mini">
    <div class="container">
        <h3 class="sub-title">CLIENT MANAGEMENT PRO IS IDEAL FOR AGENCIES DEALING WITH</h2>
        <!--<p class="title-sub">
            Lorem ipsum dolor sit amet, consetetur sadipscing elitr diam nonumy
        </p>-->
        <div id="featured" class="row">
        <div class="col-md-2">
        <img src="/images/icon-seo.png">
        <h5 class="align-c">
            SEO
        </h5>
        </div>
        <div class="col-md-2">
        <img src="/images/icon-social.png">
        <h5 class="align-c">
            Social Media
        </h5>
        </div>
        <div class="col-md-2">
        <img src="/images/icon-content.png">
        <h5 class="align-c">
            Content Marketing
        </h5>
        </div>
        <div class="col-md-2">
        <img src="/images/icon-webdesign.png">
        <h5 class="align-c">
            Web Design
        </h5>
        </div>
        <div class="col-md-2">
        <img src="images/icon-ad.png">
        <h5 class="align-c">
            Ad Management
        </h5>
        </div>
        <div class="col-md-2">
        <img src="/images/icon-graphic.png">
        <h5 class="align-c">
            Graphic Design
        </h5>
        </div>
        </div>

        
    </div><!-- /.container -->
</section><!-- /.feature-section -->

<section class="other-section other-section-1 pd-tb-mini" style="background:#002244;">
    <div class="container">
        <h3 class="align-c txt-light bold-4">Resource Planning & Project Management Software</h2>
        
        <hr class="mr-tb-40">
        <div class="row eqh fs-equalize-element">
            <div class="col-md-5 l" style="height: 670px;">
                <ol>
                    <li class="active" data-img="/images/cm-screenshot1.jpg">
                        <div class="iconwrp"><i class="fa fa-object-group"></i></div>
                        <div class="info">
                            <h4 class="hd">PROJECT MANAGEMENT</h4>
                            
                        </div>
                    </li>
                    <li data-img="/images/cm-screenshot2.jpg">
                        <div class="iconwrp"><i class="fa fa-anchor"></i></div>
                        <div class="info">
                            <h4 class="hd">PROJECT ACCOUNTING</h4>
                            
                        </div>
                    </li>
                    <li data-img="/images/cm-screenshot3.jpg">
                        <div class="iconwrp"><i class="fa fa-bell-o"></i></div>
                        <div class="info">
                            <h4 class="hd">TEAM COLLABORATION</h4>
                            
                        </div>
                    </li>
                    <li data-img="/images/cm-screenshot4.jpg">
                        <div class="iconwrp"><i class="fa fa-bullhorn"></i></div>
                        <div class="info">
                            <h4 class="hd">PROGRESS MANAGEMENT</h4>
                            
                        </div>
                    </li>
                    <li data-img="/images/cm-screenshot5.jpg">
                        <div class="iconwrp"><i class="fa fa-briefcase"></i></div>
                        <div class="info">
                            <h4 class="hd">TASK MANAGEMENT</h4>
                        
                        </div>
                    </li>
                </ol>
            </div><!-- /.col-md-5 -->
            <div class="col-md-7 r" style="height: 670px;">
                <img src="/images/cm-screenshot1.jpg" alt="Image" class="img-responsive vm-item" style="opacity: 1; margin-top: 0px;">
            </div><!-- /.col-md-6 -->

        </div>
        <div class="row pd-tb-mini">
            <div class="col-md-4">
            <h4 class="txt-light align-c">Quick Insights</h4>
            <p class="txt-light fs16 align-c">Want to know how far a client has progressed with tasks in a given month? We give you a quick progress status you can view to see exactly how many tasks were completed for that client’s campaign at anytime.</p>
            </div>
            <div class="col-md-4">
            <h4 class="txt-light align-c">Client Task Management</h4>
            <p class="txt-light fs16 align-c">Manage your client tasks with ease using a simple sub-task system for organizing your projects and to do lists.</p>
            </div>
            <div class="col-md-4">
            <h4 class="txt-light align-c">Template Management</h4>
            <p class="txt-light fs16 align-c">Have a set series of tasks for each client? Save templates for all of your tasks and import them across each client campaign. Easily implement a list of tasks you can use over and over again with new clients.</p>
            </div>
        </div>
    </div><!-- /.container -->
    
</section>

<!-- Features -->
<section class="feature-section feature-section-2 pd-tb-mini">
    <div class="container">
        <h3 class="sub-title">Designed For Ultimate Task Management</h2>
        <!--<p class="title-sub">
            Lorem ipsum dolor sit amet, consetetur sadipscing elitr diam nonumy
        </p>-->
        <div class="row">
        <div class="col-md-4">
        <img src="/images/digital-marketing-strategy.png">
        <h5 class="align-c">
            Designed For Digital</br>Marketing Agencies
        </h5>
        <p class="fs16 align-c">This software was designed with agencies and consultants in mind. Most task management tools are very broad in nature and are not designed to work with how an agency would tackle task management.</p>
        </div>
        <div class="col-md-4">
        <img src="/images/mobile-friendly.png">
        <h5 class="align-c">
            Responsive</br>Mobile Friendly
        </h5>
        <p class="fs16 align-c">Need task management on the go? Our application works great on all mobile devices and tablets.</p>
        </div>
        <div class="col-md-4">
        <img src="/images/training-videos.png">
        <h5 class="align-c">
            Add Custom</br>Training Videos
        </h5>
        <p class="fs16 align-c">Want to train your employees or virtual assistants on a specific task? Add your own custom training videos and integrate them within your client tasks.</p>
        </div>
        
        </div>
        <div class="row">
        <div class="col-md-4">
        <img src="/images/white-reporting.png">
        <h5 class="align-c">
            White Label</br>Reporting
        </h5>
        <p class="fs16 align-c">Export task reports into a PDF using your own company logo and branding. You can share these reports to show clients progress and keep them updated.</p>
        </div>
        <div class="col-md-4">
        <img src="/images/onboarding.png">
        <h5 class="align-c">
            Customized</br>Onboarding
        </h5>
        <p class="fs16 align-c">Tired of hunting down emails and documents with all your clients information? Create a customized on-boarding questionnaire for your clients asking questions about their company, password information and more to store inside of each client’s dashboard.</p>
        </div>
        <div class="col-md-4">
        <img src="/images/unlimited-users.png">
        <h5 class="align-c">
            Unlimited</br>Users & Clients
        </h5>
        <p class="fs16 align-c">We don’t have limits here. You can add unlimited clients and employees for managing your campaigns.</p>
        </div>
        
        </div>

        
    </div><!-- /.container -->
</section><!-- /.feature-section -->





<!-- Call to action-section -->
<section class="calltoaction-section calltoaction-section-1 pd-tb-mini">
    <div class="container">
        <h2 class="title medium">Get Started For Free</h2>
        
        <a href="/register" class="btn btn-default btn-lg">Register Now!</a>
    </div>
</section><!-- /.calltoaction-section -->

</div>
<!-- /#page --> 
@endsection