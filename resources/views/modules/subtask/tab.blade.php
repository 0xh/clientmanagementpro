<div class="frame bg-white" id="tasks_tab">

    <!-- Task Points -->
    
    <div class="row padding10">
            @include('task::points')
        </div>
        
        <div class="row">
            <!-- Task Status -->
            @include('task::progress')
            
        </div>
       
        <!-- Subtask table -->
        
        <div class="row">
            @include('subtask::table')
        </div>
        <!-- Activity and Comment Section -->
        <div class="row margin-bottom-90">
            <!-- Activity -->
            <div class="row" v-if="guard != 'client'">
                @include('activity::logs')
            </div>
            <!-- Comments -->
            <div class="row">
                <comments :guard="guard" :employees="employees" :tenant="tenant" :user="user" :task="task" :client="client">
                </comments>
            </div>
        </div>
</div>