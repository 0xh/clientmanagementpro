@extends('evolutly::layouts.app')
@push('critical_css')
@include('css::grid')
@include('css::footer') 
<style>
.option-wrap {
    width: 110px;
}
.name-wrap {
    width: 220px;
}
.designation-wrap {
    width: 30%;
}
</style>
@endpush @section('content')
<vue-up></vue-up>
<manage-tenants :guard="{{ json_encode($guard) }}" :users="{{ json_encode($users) }}" inline-template>
        <div>
                <div class="tabcontrol2 page-tab" data-role="tabcontrol" style="min-height:700px;padding-bottom:100px;">
                        <ul class="tabs">
                            <li>
                                <a href="#tenant_list">Tenants</a>
                            </li>
                        </ul>
                        <div class="frames bg-white">
                            <div class="padding10"></div>
                            <div id="tenant_list">
                                <div class="section-wrapper animated fadeInRightBig">
                                    <div class="panel widget-box">
                                        <div class="heading">
                                            <div class="title">Manage Tenants</div>
                                        </div>
                                        <div class="content">
                                            <div class="text">
                                                    <button @click="addTenantModal()" class="button small-button primary create-item">Add Tenant</button>
                                                    <div class="table-responsive ">
                                                        <table class="table border bordered striped ">
                                                            <thead class="">
                                                                <tr>
                                                                    <th class="name-wrap">Name</th>
                                                                    <th class="align-left">Email</th>
                                                                    <th>Joined</th>
                                                                    <th>Subscription</th>
                                                                    <th>Ends At</th>
                                                                    <th class="option-wrap">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(tenant,tenantKey,tenantIndex) in tenants" :key="tenantKey" :index="tenantIndex">
                                                                    <td>@{{ tenant.name }}</td>
                                                                    <td class="align-left">@{{ tenant.email }}</td>
                                                                    <td>
                                                                            <span  class="tag bg-steel fg-white">
                                                                                    @{{ tenant.created_at | date }}
                                                                            </span>
                                                                    </td>
                                                                    <td class="align-left">
                                                                        <span  class="tag info">
                                                                            @{{ tenant.current_plan }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="align-left">
                                                                            <span  class="tag success" v-if="tenant.subscriptions.ends_at == undefined && tenant.subscriptions.length >0">
                                                                                Subscribed
                                                                            </span>
                                                                            <span  class="tag info" v-else-if="onTrial(tenant)">
                                                                                On Trial
                                                                            </span>
                                                                            <span  class="tag bg-red fg-white" v-else-if="isExpired(tenant)">
                                                                                Expired
                                                                            </span>
                                                                            <span class="tag bg-yellow fg-white" v-else-if="isFreeLimeTimeUser(tenant)">
                                                                                Lifetime
                                                                            </span>
                                                                            <span class="tag warning" v-else>
                                                                                    @{{ tenant.subscriptions.ends_at | date }}
                                                                            </span>
                                                                    </td>
                    
                                                                    <td class="align-left">
                                                                        <span class="tag info" @click="impersonateTenant(tenant.id)" style="cursor:pointer;"
                                                                        data-role="hint" data-hint="Impersonate|Tenant" data-hint-position="left"
                                                                        >
                                                                            <span class="icon mif-eye">
                                                                            </span>
                                                                        </span>
                                                                        <span v-if="isFreeLimeTimeUser(tenant)" class="tag bg-orange fg-white" @click="downgradeSubscription(tenant,tenantKey)" style="cursor:pointer;"
                                                                        data-role="hint" data-hint="Downgrade|Free Subscription" data-hint-position="left"
                                                                        >
                                                                            <span class="icon mif-vertical-align-bottom"></span>
                                                                        </span>
                                                                        <span v-if="!isFreeLimeTimeUser(tenant)" class="tag bg-yellow fg-white" @click="upgradeSubscription(tenant,tenantKey)" style="cursor:pointer;"
                                                                        data-role="hint" data-hint="Upgrade|Lifetime Subscription" data-hint-position="left"
                                                                        >
                                                                            <span class="icon mif-vertical-align-top"></span>
                                                                        </span>
                                                                        </span>
                                                                        <span class="tag bg-red fg-white" @click="showDeleteModal(tenant,tenantKey)" style="cursor:pointer;"
                                                                        data-role="hint" data-hint="Delete|Tenant" data-hint-position="left"
                                                                        >
                                                                            <span class="icon fa fa-trash"></span>
                                                                            </span>
                                                                        </span>
                                                                    </td>
                                                                    
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                @include('tenant::add-tenant-modal')
                {{-- @include('employee::edit-tenant-modal') --}}
                @include('tenant::delete-tenant-modal')
            </div>
</manage-tenants>

@endsection

@push('footer_js')

@endpush