<?php

namespace Modules\Evolutly\Configuration;


trait ManageModelOptions
{
    /**
     * The user model class name.
     *
     * @var string
     */
    public static $userModel = 'App\User';

    /**
     * The Employee model class name.
     *
     * @var string
     */
    public static $employeeModel = 'App\Employee';

    /**
     * The Employee model class name.
     *
     * @var string
     */
    public static $clientModel = 'App\Client';



    /**
     * Set the user model class name.
     *
     * @param  string  $userModel
     * @return void
     */
    public static function useUserModel($userModel)
    {
        static::$userModel = $userModel;
    }

    /**
     * Set the user model class name.
     *
     * @param  string  $userModel
     * @return void
     */
    public static function useEmployeeModel($employeeModel)
    {
        static::$employeeModel = $employeeModel;
    }

    /**
     * Set the user model class name.
     *
     * @param  string  $userModel
     * @return void
     */
    public static function useClientModel($clientModel)
    {
        static::$clientModel = $clientModel;
    }

    /**
     * Get the user model class name.
     *
     * @return string
     */
    public static function userModel()
    {
        return static::$userModel;
    }

    /**
     * Get the Employee model class name.
     *
     * @return string
     */
    public static function employeeModel()
    {
        return static::$employeeModel;
    }

    /**
     * Get the Client model class name.
     *
     * @return string
     */
    public static function clientModel()
    {
        return static::$clientModel;
    }

    /**
     * Get a new user model instance.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public static function user()
    {
        return new static::$userModel;
    }

    /**
     * Get a new employee model instance.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public static function employee()
    {
        return new static::$employeeModel;
    }

    /**
     * Get a new client model instance.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public static function client()
    {
        return new static::$clientModel;
    }

}
