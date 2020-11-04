<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
//use Illuminate\Foundation\Auth\RegistersUsers;
use BlackBits\LaravelCognitoAuth\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use BlackBits\LaravelCognitoAuth\Exceptions\InvalidUserFieldException;
use BlackBits\LaravelCognitoAuth\CognitoClient;
use Session;


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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', 'confirmed'],
        ]);
    }

    public function register(Request $request,CognitoClient $cognitoClient)
    {
        $this->validator($request->all())->validate();

        $attributes = [];

        $userFields = config('cognito.sso_user_fields');

        foreach ($userFields as $userField) {
            if ($request->filled($userField)) {
                $attributes[$userField] = $request->get($userField);
            } else {
                throw new InvalidUserFieldException("The configured user field {$userField} is not provided in the request.");
            }
        }



        app()->make(CognitoClient::class)->register($request->email, $request->password, $attributes);

        event(new Registered($user = $this->create($request->all())));

        $cognitoClient->setUserAttributes($user->email, [
            'email_verified' => 'true'
        ]);

        $cognitoClient->confirmSignUp($user->email);

        if($user) {
            $this->guard()->login($user);
        }


        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function reditectPath()
    {
        return url('/');
    }

    protected function registered(Request $request, $user)
    {
        $message = 'Successful registration. We have sent you an email to verify it.';
        $request->session()->flash('success', $message);
        return redirect()->to($this->redirectPath());
    }
}
