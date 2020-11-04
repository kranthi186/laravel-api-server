<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cognito\CognitoClient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    public function login(Request $request, CognitoClient $cognitoClient)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        $response = [];
        if($user) {
            $user->makeVisible('password');
            if(Hash::check($credentials['password'], $user->password)) {
                $response = $cognitoClient->authenticate($credentials['email'], $credentials['password'],$user->name);
                $code = $response['authentication'] == false ? 401 : 200;
            } else {
                $response['authentication'] = false;
                $response['message'] = 'Invalid Password';
                $code = 401;
            }

        } else {
            $response['authentication'] = false;
            $response['message'] = 'User not found';
            $code = 401;
        }


        

        return response()->json(compact('response'), $code);
    }
}
