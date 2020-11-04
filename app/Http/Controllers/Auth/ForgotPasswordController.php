<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use BlackBits\LaravelCognitoAuth\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use BlackBits\LaravelCognitoAuth\CognitoClient;
use Illuminate\Http\Request;
use Session;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request,CognitoClient $cognitoClient)
    {
        $this->validateEmail($request);

        $response = $cognitoClient->sendResetLink($request->email);


        
        Session::put('reset_form', 1);
     
       
        if ($response == Password::RESET_LINK_SENT) {
            return redirect(url('/'));
        }

        return $this->sendResetLinkFailedResponse($request, $response);
    }
}
