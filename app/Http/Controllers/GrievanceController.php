<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Grievance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class GrievanceController extends Controller
{
    public function index(){
        $data_grievance = Grievance::query()->get();
        $data = [
            'data_grievance' => $data_grievance
        ];
        return view('GISView.Map',$data);
    }

    public function edit(Request $request){
        $user = Users::where('user_id', Session::get('id_petugas'))->first();
        $id = $request->id;
        $grievance = Grievance::query()->where('grievance_id',$id)->first();
        $data = [
            'user' => $user,
            'grievance' => $grievance
        ];
        return view('GISView.petugas.edit_grievance',$data);
    }

    public function create_grievance(Request $request){
        $user = Users::where('user_id', Session::get('id_petugas'))->first();
        $rules = [
            'issue' => 'required',
            'lattitude' => 'required',
            'longitude' => 'required',
            'category' => 'required',
            'locations' => 'required',
            'complainants' => 'required',
            'image_location' => 'required|max:2048',
            'kampung' => 'sometimes|nullable',
            'desa' => 'sometimes|nullable',
            'rt_rw' => 'sometimes|nullable',
            'no_ktp' => 'sometimes|nullable',
            'no_telp' => 'sometimes|nullable',
            'jalur_aduan' => 'sometimes|nullable',
            'tanggal' => 'sometimes|nullable'
        ];

        $message = [
            'issue.required' => 'Issue is required',
            'lattitude.required' => 'lattitude is required',
            'longitude.required' => 'longitude is required',
            'category.required' => 'category is required',
            'locations.required' => 'locations is required',
            'complainants.required' => 'complainants is required',
            'image_location.required' => 'image_location is required',
            'image_location.max' => 'image_location max 2MB',
        ];

        $validated = Validator::make($request->all(),$rules,$message);
        if($validated->fails()){
            $error = implode(", ", array_map('implode', array_values($validated->errors()->messages())));
            Alert::error('Oops!', $error);
            return redirect()->back();
        }

        $data = $validated->validate();

        if($request->file('image_location')){
            $image = $request->getSchemeAndHttpHost() . '/storage/' . $request->file('image_location')->store('image', 'public');
            $data['image_location'] = $image;
        }

        if ($request->has('image_ttd')) {
            $signatureData = $request->input('image_ttd');
            $signatureImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData));
            $imageName = 'signature_' . time() . '.png'; // Nama gambar yang akan disimpan

            // Simpan gambar ke penyimpanan (storage)
            $request->getSchemeAndHttpHost() . Storage::put('public/image/' . $imageName, $signatureImage);
            $data['image_ttd'] = $imageName;
        }

        if($request->id){
            $is_updated = Grievance::query()->where('grievance_id', $request->id)->update($data);
            dd($is_updated);
            if(!$is_updated){
                Alert::error('Oops!, Data Gagal Diupdate');
                return redirect()->back();
            }
            Alert::success('Data Berhasil Diupdate');
            return redirect()->back();
        }
        $data['user_id'] = $user->user_id;
        $data['status'] = "Reported";
        Grievance::create($data);
        Alert::success('Data Successfully Created');
        return redirect()->back();
    }

    public function detail(Request $request){
        $id = $request->id;
        $users = Users::query()->where('user_id',session()->get('id_petugas'))->first();
        $grievance = Grievance::query()->where('grievance_id', $id)->first();
        $data = [
            'grievance' => $grievance,
            'user' => $users,
        ];
        return view('GISView.petugas.detail_grievance',$data);
    }

    public function delete(Request $request){
        $id = $request->id;
        $is_delete = Grievance::query()->where('grievance_id', $id)->delete();
        if(!$is_delete) {
            Alert::error('Oops! Data Gagal Dihapus');
            return redirect()->back();
        }
        Alert::success('Oops! Data Berhasil Dihapus');
        return redirect()->back();
    }
}
