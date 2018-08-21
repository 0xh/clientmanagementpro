<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Events\Auth\UserRegistered;
use Laravel\Spark\Contracts\Http\Requests\Auth\RegisterRequest;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Laravel\Spark\Contracts\Interactions\Auth\Register;
// use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Spark\Http\Controllers\Auth\RegisterController as Controller;
use App\Notifications\RegistrationWelcomeEmail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        $this->redirectTo = Spark::afterLoginRedirect();
    }
    /**
     * Show the application registration form.
     *
     * @param  Request  $request
     * @return Response
     */
    public function showRegistrationForm(Request $request)
    {
        if (Spark::promotion() && ! $request->has('coupon')) {
            // If the application is running a site-wide promotion, we will redirect the user
            // to a register URL that contains the promotional coupon ID, which will force
            // all new registrations to use this coupon when creating the subscriptions.
            return redirect($request->fullUrlWithQuery([
                'coupon' => Spark::promotion()
            ]));
        }

        return view('spark::auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function register(RegisterRequest $request)
    {
        Auth::login($user = Spark::interact(
            Register::class, [$request]
        ));

        event(new UserRegistered($user));
        $user->notify(new RegistrationWelcomeEmail($user));

        return response()->json([
            'redirect' => '/dashboard'
        ]);
    }
}
