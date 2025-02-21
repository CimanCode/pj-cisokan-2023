<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Users;
use App\Models\Grievance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(){
        $user = Users::query()->where('role_id',Session::get('id_role_admin'))->first();
        $data_grievance = Grievance::query()->get();
        $data = [
            'user' => $user,
            'grievance' => $data_grievance
        ];
        return view('GISView.admin.Map',$data);
    }

    public function master()
    {
        $user = Users::query()->where('role_id', Session::get('id_role_admin'))->first();

        // Menggunakan paginate() untuk menghasilkan data yang dapat dipaginasi
        $data_grievance = Grievance::paginate(10); // Menampilkan 10 item per halaman
        $petugas = Users::query()->join('role','role.role_id','=','user.role_id')->where('role.name','petugas')->get();
        $data = [
            'user' => $user,
            'petugas' => $petugas,
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

    public function addPetugas(Request $request){

        try {
            $role = Role::query()->where('name','petugas')->first();
            $data = [
                'role_id' => $role->role_id,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password,
                'api_token_petugas' => Str::random(16),
            ];

            if($data['username'] == null || $data['email'] == null || $data['password'] == null){
                Alert::error('Oops!', 'Semua Data Harus Disi');
                return redirect()->back();
            }

            Users::create($data);
            Alert::success('Data Petugas Berhasil Ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            throw $th;
            Alert::error('Oops!', 'Terjadi Kesalahan');
            return redirect()->back();
        }
    }

    public function deletepetugas($id){
        if($id){
            $is_deleted = Users::query()->where('user_id',$id)->delete();
            if($is_deleted){
                Alert::success('Data Berhasil Dihapus');
                return redirect()->back();
            }
            Alert::error('Data Gagal Dihapus');
            return redirect()->back();
        }

        Alert::error('Id Petugas Tidak Ditemukan');
        return redirect()->back();
    }

    public function updateProgress(Request $request){
        try {
            $id = $request->grievance_id;
            if($id){
                $rules = [
                    'status' => 'nullable',
                    'tindak_lanjut' => 'nullable',
                ];

                $message = [];

                $validated = Validator::make($request->all(),$rules,$message);

                if($validated->fails()){
                    $error = implode(", ", array_map('implode', array_values($validated->errors()->messages())));
                    Alert::error('Oops!', $error);
                    return redirect()->back()->withInput();
                }

                $data = $validated->validate();

                $is_updated = Grievance::query()->where('grievance_id', $id)->update($data);
                if($is_updated){
                    Alert::success('Data Berhasil Diupdate');
                    return redirect()->back();
                }
                Alert::error('Data Gagal Diupdate');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }

}
