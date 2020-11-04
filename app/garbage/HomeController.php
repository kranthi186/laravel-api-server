<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Administrator;
use App\Models\User;
use App\Models\Url;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
        $this->middleware('authAdmin', ['except' => array('welcome')]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $admins = Administrator::all()->count();
        $users = User::all()->count();
        $urls = Url::all()->count();
        return view('pages.admin.home')->with(compact('admins', 'users', 'urls'));
    }

    public function welcome(){



        if(Session::get('signup_form'))
        {
          $signup_form = Session::get('signup_form');


          Session::put('signup_form', 0);

          $data['signup_form'] = $signup_form;
        }
        else
        {
            $data['signup_form'] = 0;
        }





        return view('welcome',['signup_form'=>$data['signup_form']]);
    }
}
