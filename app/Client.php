<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Client\Notifications\ResetPasswordNotification;
use App\Traits\ModelBuilder\ClientBuilder;
use Laravel\Spark\HasApiTokens;

class Client extends Authenticatable
{
    use ClientBuilder, HasApiTokens;

    protected $table ='clients';

    protected $guard = 'client';

    protected $fillable = [
        'name',
        'email',
        'photo_url',
        'first_name',
        'last_name',
        'address',
        'address_line_2',
        'city',
        'zip',
        'country',
        'country_code',
        'links',
        'notes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'links' => 'array',
    ];

    public function sendPasswordResetNotification($token, $email = null)
    {
        $this->notify(new ResetPasswordNotification($token, $email ? $email : $this->email));
    }

    public function projects()
    {
        return $this->hasMany('App\Project');
    }
}
