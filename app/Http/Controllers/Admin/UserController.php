<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use BlackBits\LaravelCognitoAuth\CognitoClient;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.user.users', [
            'page' => 'users', 
            'users' => $users
        ]);
    }

    public function apiUsers(Request $request) {
        return response()->json(User::all(), 200);
    }

    public function editUser($id) {
        $user = User::find($id);
        return view('admin.user.edit_user', ['page' => 'users', 'user' => $user]);
    }

    public function apiEditUser($id) {
        $user = User::find($id);
        return response()->json($user, 200);
    }

    public function postEditUser($id, Request $request, CognitoClient $cognitoClient) {
        $validator = $this->updateValidator($request->all());

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $user = User::find($id);
        $oldEmail = $user->email;

        $status = $request->user_status;
        $email = $request->email;
        $password = $request->password;
        $user_type = $request->user_type;

        $user->status = $status;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->user_type = $user_type;
        $user->save();

        $cognitoClient->setUserPassword($oldEmail, $password);
        $cognitoClient->setUserAttributes($oldEmail, [
            'email' => $email, 
            'email_verified' => 'true', 
        ]);

        return redirect()->to('users');
    }

    public function apiPostEditUser($id, Request $request, CognitoClient $cognitoClient) {
        $validator = $this->updateValidator($request->all());

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $user = User::find($id);
        $oldEmail = $user->email;

        $status = $request->user_status;
        $email = $request->email;
        $password = $request->password;
        $user_type = $request->user_type;

        $user->status = $status;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->user_type = $user_type;
        $user->save();

        $cognitoClient->setUserPassword($oldEmail, $password);
        $cognitoClient->setUserAttributes($oldEmail, [
            'email' => $email, 
            'email_verified' => 'true', 
        ]);

        return response()->json($user, 200);
    }

    public function addUser(Request $request, CognitoClient $cognitoClient) {
        $validator = $this->validator($request->all());

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $status = $request->user_status;
        $email = $request->email;
        $password = $request->password;
        $user_type = $request->user_type;

        $attributes = [
            'phone_number' => ''
        ];

        app()->make(CognitoClient::class)->register($email, $password, $attributes);

        $user = new User();
        $user->username = $email;
        $user->status = $status;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->user_type = $user_type;
        $user->save();
        // event(new Registered($user = $this->create($request->all())));
        $cognitoClient->setUserAttributes($email, [
            'email_verified' => 'true', 
        ]);
        $cognitoClient->confirmSignUp($email);

        return redirect()->to('users');
    }

    protected function validator(array $data)
    {
        $messages = [
            'email.required' => 'Required email',
            'email.email' => 'Email is incorrect',
            'email.unique' => 'Existed email',
            'password.required' => 'Required password',
            'password.regex' => 'Password should be contain uppercase and lowercase character, at least 1 number and at least 1 symbol.',
            'password.min' => 'Password minimum length is 8',
            'user_type.min' => 'Required User Type', 
        ];

        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/'],
            'user_type' => ['min:1']
        ], $messages);
    }

    protected function updateValidator(array $data)
    {
        $messages = [
            'email.required' => 'Required email',
            'email.email' => 'Email is incorrect',
            'password.required' => 'Required password',
            'password.regex' => 'Password should be contain uppercase and lowercase character, at least 1 number and at least 1 symbol.',
            'password.min' => 'Password minimum length is 8',
            'user_type.min' => 'Required User Type', 
        ];

        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/'],
            'user_type' => ['min:1']
        ], $messages);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(/*User $user*/$email, CognitoClient $cognitoClient)
    {
        $user = User::where('email', $email)->first();
        $user->delete();
        $cognitoClient->deleteUser($email);
    }
}
