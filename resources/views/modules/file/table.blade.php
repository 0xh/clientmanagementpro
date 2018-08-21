<div class="panel widget-box">
    <div class="heading">
        <div class="title">
            <div class="align-center"  data-role="hint"
                data-hint-mode="2" data-hint="Click Or Drag|Files Here" data-hint-position="top">
                <file-upload class="primary" :name="name" :post-action="postAction" :extensions="extensions" :accept="accept"
                    :multiple="multiple" :directory="directory" :size="size || 0" :thread="thread < 1 ? 1 : (thread > 5 ? 5 : thread)"
                    :headers="headers" :data="data" :drop="drop" :drop-directory="dropDirectory" v-model="files" @input-file="inputFile"
                    ref="upload">
                    <span class="fg-white icon fa fa-cloud-upload" > Upload Files</span>
                </file-upload>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Progress</th>
                        <th>Active</th>
                        <th>Error</th>
                        <th>Success</th>
                        <th>Abort</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(file, index) in files">
                        <td v-if="file.type.substr(0, 6) == 'image/' && file.blob">
                            <img :src="file.blob" width="50" height="auto" />
                        </td>
                        <td v-else></td>
                        <td>@{{file.name}}</td>
                        <td>@{{file.size | formatSize}}</td>
                        <td>@{{file.progress}}</td>
                        <td>@{{file.active}}</td>
                        <td>@{{file.error}}</td>
                        <td>@{{file.success}}</td>
                        <td><span style="cursor:pointer;" class="icon fa fa-times fg-amber" @click.prevent="abort(file)"></span></td>
                        <td><span style="cursor:pointer;" class="icon fa fa-trash fg-red" @click.prevent="remove(file)"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row cells12">
            <div class="cell colspan6 place-left align-left">
                <span style="cursor:pointer;" class="icon fg-teal" :class="{ 'mif-play': hasFiles, 'mif-plus': noFile }" v-show="$refs.upload && !$refs.upload.active"  @click.prevent="$refs.upload.active = true">
                    <span v-if="noFile"> Drag Files Here</span><span v-else>Start Upload</span>
                </span>
                <span style="cursor:pointer;" class="icon mif-stop fg-red" v-show="$refs.upload && $refs.upload.active"  @click.prevent="$refs.upload.active = false">
                    Stop Upload
                </span>
            </div>
            <div class="cell colspan6 place-left">
                
                <span style="font-size:1.5em" class="icon fg-blue fa fa-spinner fa-pulse fa-3x fa-fw" v-show="$refs.upload && $refs.upload.active"></span>
            </div>
        </div>

        <div class="row cells12">
            <div class="cell colspan12">
                <p class="place-left fg-blue">File Extensions Allowed: <span class="tag info" v-text="extensions"></span></p>
            </div>
        </div>
        <div class="row" v-show="$refs.upload && $refs.upload.dropActive" class="drop-active align-center">
            <span class="fg-blue icon fa fa-cloud-upload" style="font-size:5em;"></span>
        </div>
    </div>
</div>
