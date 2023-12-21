<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Grievance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PetugasController extends Controller
{
    public function index(){
        $users = Users::query()->where('user_id',session()->get('id_petugas'))->first();
        $data_grievance = Grievance::query()->where('user_id',$users->user_id)->get();
        // dd($data_grievance);
        $data = [
            'user' => $users,
            'data_grievance' => $data_grievance,
        ];
        return view('GISView.petugas.Map', $data);
    }

    public function getFileKmz(){
        $kmz = file_get_contents("Peta_Lokasi_Proyek.kmz",true);
        return response()->json($kmz);
    }
}
