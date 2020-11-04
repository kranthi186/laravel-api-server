<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use BlackBits\LaravelCognitoAuth\CognitoClient;
use BlackBits\LaravelCognitoAuth\CognitoUserPropertyAccessor;
use App\Models\User;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth')
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verifyEmail(
        $token,
        CognitoClient $cognitoClient,
        CognitoUserPropertyAccessor $cognitoUserPropertyAccessor
    ) {
        $user = User::whereToken($token)->firstOrFail();

        $user->token = null;
        $user->save();

        $cognitoClient->setUserAttributes($user->email, [
            'email_verified' => 'true'
        ]);

        $cognitoClient->confirmSignUp($user->email);

        if ($cognitoUserPropertyAccessor->getUserStatus($user->email) != 'CONFIRMED') {
            $cognitoClient->confirmSignUp($user->email);
            return response()->redirectToRoute('login');
        }

        return response()->redirectToRoute('dashboard');
    }
}
