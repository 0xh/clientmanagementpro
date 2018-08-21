<div class="content">
        <div class="text">
            <div class="row cells12">
                <div class="cell colspan12">
                    <div class="tabcontrol" data-role="tabcontrol">
                        <ul class="tabs">
                            <li><a href="#template_tab">Pre-Built Templates</a></li>
                            <li><a href="#my_template">My Templates</a></li>
                            <!-- <li><a href="#onboarding_tab" v-if="guard ==='web'">Forms</a></li> -->
                        </ul>
                        <div class="frames bg-white" style="min-height:500px;padding-bottom:100px;">
                            @include('template::tab')
                            @include('template::my_template')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
