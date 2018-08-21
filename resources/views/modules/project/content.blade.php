<div class="content">
    <div class="text">
        @include('project::action_buttons')
        <div class="row cells12">
            <div class="cell colspan12">
                <div class="tabcontrol" data-role="tabcontrol">
                    <ul class="tabs">
                        <li><a href="#tasks_tab">Campaigns</a></li>
                        <!-- <li><a href="#onboarding_tab" v-if="guard ==='web'">Forms</a></li> -->
                        <li v-if="guard === 'web'"><a href="#uploads_tab">Upload</a></li>
                        <li v-if="guard === 'web'"><a href="#uploaded_tab">Files</a></li>
                        <!-- <li><a href="#people_tab">Team</a></li> -->
                    </ul>
                    <div class="frames bg-white">
                        @include('task::tab')
                        {{-- @include('form::tab') --}}
                        @include('file::tab')
                        @include('file::uploaded')
                        {{-- @include('employee::tab') --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>