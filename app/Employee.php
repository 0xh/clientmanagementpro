<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Employee\Notifications\ResetPasswordNotification;
use App\Traits\ModelBuilder\EmployeeBuilder;
use Laravel\Spark\HasApiTokens;

class Employee extends Authenticatable
{
    use EmployeeBuilder,HasApiTokens;
    
    protected $table ='employees';

    protected $guard = 'employee';

    protected $fillable = [
        'name',
        'email',
        'photo_url'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function sendPasswordResetNotification($token, $email = null)
    {
        $this->notify(new ResetPasswordNotification($token, $email ? $email : $this->email));
    }

    public function assignedprojects()
    {
        return $this->belongsToMany('App\Project', 'employee_subtask', 'employee_id', 'project_id')->distinct();
    }
}
