<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;
use App\Notifications\RegistrationWelcomeEmail;
use Carbon\Carbon;
use Laravel\Spark\Spark;

class AddTenant extends BaseController
{
    protected $user;
    
    protected $request;

    protected $message = 'Lifetime Tenant Account Created';

    protected $code = '200';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user,Request $request)
    {
        $this->middleware(['auth']);
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $validator = $this->sanitize();

        if($validator->fails()){
            if($this->request->lifetime){
                $this->message = 'Failed To Create Lifetime Tenant Account';
            
            }else {
                $this->message = 'Failed to Create Trial Account';
            }
            $this->code = 422;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }

        $this->user->forceFill([
            'name' => $this->request->name,
            'email' => $this->request->email,
            'password' => $this->request->password,
            'last_read_announcements_at' => Carbon::now(),
        ]);
        if($this->request->lifetime === false){
            $this->user->forceFill([
                'trial_ends_at' => Carbon::now()->addDays(Spark::trialDays()),
            ]);
        }
        $this->user->save();
        
        if($this->request->sendEmail === true){
            $this->user->notify(new RegistrationWelcomeEmail($this->user));
        }
        
        return response()->json(['message' => $this->message, 'user' => $this->user], $this->code);
    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'name' => 'required|max:60',
        'email' => 'required|email|unique:clients,email',
        'password' => 'required|min:6|max:60',
        ];
    }

    private function messages(){
        return [
            'name.required' => 'Company Name Field is Required',
            'name.max' => 'Company Name is Too Long (60) Max',
            'email.required' => 'Email is Required',
            'email.email' => 'Email Format Is Invalid',
            'email.unique' => 'Email Is Already taken',
            'password.min' => 'Password Needs to Be At Least (6) Characters',
            'password.max' => 'Password Exceeds 60 Characters',
            'password.required' => 'Password is Required',
        ];
    }

}