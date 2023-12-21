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
            Alert::error('Oops!','An error occurred');
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
        $data['user_id'] = $user->user_id;
        $data['status'] = "Reported";
        Grievance::create($data);
        Alert::success('Data Successfully Created');
        return redirect()->back();
    }
}
