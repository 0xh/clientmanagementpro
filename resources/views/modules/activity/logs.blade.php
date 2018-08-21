<div class="cell" v-if="logs">
        <div class="panel widget-box warning" data-role="panel">
            <div class="heading align-center">
                <div class="title">Activity Logs</div>
            </div>
            <div class="content">
                <ul class="timeline-list" v-if="logs.length > 0">
                    <li v-for="(log, logKey) in logs" v-if="Object.keys(log.properties.attributes).length > 0">
                        <div class="date">
                            <span class="icon fa fa-briefcase"></span>
                            <small>@{{ log.updated_at | relative }} ago</small>
                        </div>
                        <h5 >@{{ log.description }}</h5>
                        <div class="content">
                            <div v-for="(properties,propsKey) in log.properties">
                                <h5>@{{ (propsKey === 'attributes' ? 'Changes: ' : 'Old Values: ') }}</h5>
                                <ul>
                                    <li v-for="(change,key) in properties">
                                        @{{ key }} : @{{ change }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>