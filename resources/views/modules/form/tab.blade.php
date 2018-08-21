<div class="frame" id="onboarding_tab" v-if="guard === 'web'">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title">Visual Form Builder</div>
        </div>
        <div class="content">
            <div class="text">

                <div class="fluent-menu" data-role="fluentmenu">
                    <ul class="tabs-holder">
                        <li class="active"><a href="#basic">Create Form</a></li>
                        <li><a href="#code">Code</a></li>
                    </ul>

                    <div class="tabs-content">

                        <div class="tab-panel" id="basic">
                            <div class="tab-panel-group">
                                <div class="tab-group-content">
                                    <button class="fluent-button" id="add_header">
                                            <span class="icon fa fa-header"></span>
                                            <span>Header</span>
                                        </button>
                                    <button class="fluent-button" id="add_text">
                                            <span class="icon fa fa-edit"></span>
                                            <span>Text</span>
                                        </button>
                                    <button class="fluent-button" id="add_textarea">
                                            <span class="icon fa fa-edit"></span>
                                            <span>Textarea</span>
                                        </button>
                                </div>
                                <div class="tab-group-caption">Text</div>
                            </div>
                            <div class="tab-panel-group">
                                <div class="tab-group-content">
                                    <button class="fluent-button" id="add_checkbox">
                                            <span class="icon fa fa-check-square-o"></span>
                                            <span>Checkbox</span>
                                        </button>
                                    <button class="fluent-button" id="add_radio">
                                            <span class="icon fa fa-dot-circle-o"></span>
                                            <span>Radio</span>
                                        </button>
                                    <button class="fluent-button" id="add_switch">
                                            <span class="icon fa fa-toggle-on"></span>
                                            <span>Switch</span>
                                        </button>
                                </div>
                                <div class="tab-group-caption">Option</div>
                            </div>
                            <div class="tab-panel-group">
                                <div class="tab-group-content">
                                    <button class="fluent-button" id="add_select">
                                            <span class="icon fa fa-angle-down"></span>
                                            <span>Select</span>
                                        </button>
                                    <button class="fluent-button" id="add_file">
                                            <span class="icon fa fa-upload"></span>
                                            <span>File</span>
                                        </button>
                                    <button class="fluent-button" id="add_button">
                                            <span class="icon fa fa-toggle-right"></span>
                                            <span>Button</span>
                                        </button>

                                </div>
                                <div class="tab-group-caption">More</div>
                            </div>

                        </div>
                        <!-- code -->
                        <div class="tab-panel" id="code">
                            <div class="tab-panel-group">
                                <div class="tab-group-content">
                                    <button class="fluent-big-button" id="show_code">
                                            <span class="icon fa fa-eye"></span>
                                            <span>Show / Hide<br/>Code</span>
                                        </button>
                                    <button class="fluent-big-button" id="build_code">
                                            <span class="icon fa fa-cloud-download"></span>
                                            <span>Build<br/>Code</span>
                                        </button>
                                </div>
                                <div class="tab-group-caption">Code</div>
                            </div>
                            <div class="tab-panel-group">
                                <div class="tab-group-content">

                                    <div class="tab-content-segment">
                                        <button class="fluent-button">
                                                <div class="input-control textarea">
                                                    <textarea name="" id="zen_input" placeholder="try table.table>tr>th{heading}*3"
                                                    ></textarea>
                                                </div>
                                            </button>
                                    </div>
                                    <div class="tab-content-segment">
                                        <button class="fluent-button">
                                                <div class="input-control textarea">
                                                    <textarea name="" id="zen_output" 
                                                    ></textarea>
                                                </div>
                                            </button>
                                    </div>

                                </div>
                                <div class="tab-group-caption">Zen Code Tools</div>
                            </div>
                        </div>

                    </div>
                </div>

                <div id="form_preview" class="grid bg-grayLight padding10 bg-chess" style="min-height: 250px;">
                    <div class="row cells3">
                        <div class="cell colspan2">

                            <div class="panel widget-box">
                                <div class="heading">
                                    <div class="title">Form Builder</div>
                                </div>
                                <div class="content">
                                    <div class="text" id="form_layout">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cell"></div>
                    </div>
                </div>
                <div class="input-control full-size textarea hide" id="code_build">
                    <label>Generated Code</label>
                    <textarea name="" id="text_code" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="hide" id="zen_area"></div>
</div>