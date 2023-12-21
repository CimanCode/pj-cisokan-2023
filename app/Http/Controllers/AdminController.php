<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Grievance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index(){
        $user = Users::query()->where('role_id',Session::get('id_role_admin'))->first();
        $data_grievance = Grievance::query()->get();
        $data = [
            'user' => $user,
            'data_grievance' => $data_grievance
        ];
        return view('GISView.admin.Map',$data);
    }
}
