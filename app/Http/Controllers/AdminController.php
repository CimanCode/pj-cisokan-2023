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
    public function master()
    {
        $user = Users::query()->where('role_id', Session::get('id_role_admin'))->first();
        
        // Menggunakan paginate() untuk menghasilkan data yang dapat dipaginasi
        $data_grievance = Grievance::paginate(10); // Menampilkan 10 item per halaman
        
        $data = [
            'user' => $user,
            'data_grievance' => $data_grievance
        ];
        
        return view('GISView.admin.pageMaster', $data);
    }
    public function laporan()
    {
        $user = Users::query()->where('role_id', Session::get('id_role_admin'))->first();
        
        // Menggunakan paginate() untuk menghasilkan data yang dapat dipaginasi
        $data_grievance = Grievance::paginate(10); // Menampilkan 10 item per halaman
        
        $data = [
            'user' => $user,
            'data_grievance' => $data_grievance
        ];
        
        return view('GISView.admin.laporan', $data);
    }
    
}
