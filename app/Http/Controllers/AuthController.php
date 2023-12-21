<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $admin = Users::query()->where('email', $email)->first();
        if(empty($admin)){
            Alert::error('Oops!','Email Not Found');
            return redirect()->back();
        }
        if(!Hash::check($password, $admin->password)){
            Alert::error('Oops!','Password Validation Failed');
            return redirect()->back();
        }
        if(!session()->isStarted())
            session()->start();
            session()->put('logged','yes',true);
            session()->put('api_token',$admin->api_token_petugas);
            session()->put('id_petugas',$admin->user_id);
            session()->put('id_role_admin',$admin->role_id);
            if(Session::get('api_token'))
                return redirect(route('petugasmap'));
            if(Session::get('id_role_admin'))
                return redirect(route('adminMap'));
    }

    public function logout(){
        session()->flush();
        return redirect(route('home'));
    }
}
