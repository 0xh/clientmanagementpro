<?php

namespace Modules\Evolutly;

use Modules\Evolutly\Contracts\InitialFrontendState as Contract;
use Illuminate\Auth\AuthManager;
use App\Project;
use Route;
use App\Task;
use App\Employee;
use App\User;
use App\Client;

class InitialFrontendState implements Contract
{
    protected $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }
    public function forUser($user)
    {
        // make a method to determine what variable for user we will return
        return $this->getData();
    }

    protected function getData() {
        // we always return a user and a tenant
        $data = array_merge(array(),['user' => $this->currentUser()]);
        $data = array_merge($data,['tenant' => $this->getTenant()]);
        $data = array_merge($data,['clients' => $this->getClients()]);
        $data = array_merge($data,['employees' => $this->getEmployees()]);
        // if we are on the dashboard of the all types of user
        $dashboardRoutes = array("dashboard", "employee.dashboard", "client.dashboard");
        if (in_array(Route::currentRouteName(), $dashboardRoutes)) {
        $data = array_merge($data,['projects' => $this->projects()]);
        }
        // if we are on the Tenants Manage Team Member
        if(in_array(Route::currentRouteName(), ['tenant.employees.index'])){
            $data = array_merge($data,['projects' => $this->getProjects()]);
        }
        // if we are on the specific project page
        // This Part is Working But WE Will Comment This Out For the Mean Time
        // $projectRoutes = array("employee.projects.view", "client.projects.view", "tenant.projects.view");
        // if (in_array(Route::currentRouteName(), $projectRoutes)) {
        // $data = array_merge($data,['currentProject' => $this->currentProject()]);
        // $data = array_merge($data,['currentProjectFiles' => $this->currentProjectFiles()]);
        // $data = array_merge($data,['currentProjectWorkers' => $this->currentProjectWorkers()]);
        // }
        return $data;
        
    }
    protected function getTenant()
    {
        $user = $this->currentUser();
        if($user instanceOf User){
            return $user->select('id','username','name','photo_url')->first(); 
        }
        return $user->byTenant();
    }

    protected function getClients()
    {
        $user = $this->currentUser();
        if($user instanceOf User){
            $clients = $user->clients;
            if(count($clients)){
                return $clients;
            }
            return [];
        }
        $clients = User::find($user->tenant_id)->clients;
        if(count($clients)){
            return $clients;
        }
        return [];
    }

    protected function getEmployees()
    {
        $user = $this->currentUser();
        if($user instanceOf User){
            $employees = $user->employees;
            if(count($employees)){
                return $employees;
            }
            return [];
        }
        $employees = User::find($user->tenant_id)->employees;
        if(count($employees)){
            return $employees;
        }
        return [];
    }
    
    protected function getProjects()
    {
        $user = $this->currentUser()->load('projects.assignedEmployees')->toArray();
        $projects = $user['projects'];
        return $projects;
    }
    // default should only be the user
    // for dashboard we add projects
    // fro project we add project , campaigns, files, workers

    protected function projects()
    {
        $user = $this->currentUser();
        
        if($user instanceOf User){
            return $user->manageProjects()->get()->toArray();
        }elseif($user instanceOf Employee){
           // we get the tenant of employee
           $tenant = $user->byTenant();
           // we get list of project ids
           $project_list = $tenant->manageProjects()->pluck('id')->toArray();
           $projects = array();
           $count = 0;
           // filter the projects in employee_subtasks table using the product id
           foreach ($project_list as $id) {
               $project = Project::find($id);
               $employees = $project->assignedEmployees()->pluck('id')->toArray();
               if(in_array($user->id,$employees)){
               $projects = array_merge($projects,[$count => $project]);
               $count++;
               }
           }
           // return Only Projects Assigned to that Employee
           return $projects;
        }elseif($user instanceOf Client){
            return $user->projects()->get()->toArray();
        }
    }


    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function currentUser()
    {
        $guard = $this->getUsedGuardOrDefaultDriver();
        return $this->auth->guard($guard)->user();
    }

    protected function getGuardsFromConfig()
    {
        return collect(config('auth.guards'))->keys()->toArray();
    }

    protected function getUsedGuardOrDefaultDriver()
    {
        $guards = $this->getGuardsFromConfig();
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $guard;
            }
        }
        return $auth->getDefaultDriver();
    }

    
}
