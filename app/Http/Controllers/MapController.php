<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Pemetaan'
        ];
        return view('GISView.Map', $data);
    }

    public function getMap(){
        $kml = file_get_contents('layers.kml');
        if(!$kml){
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $kml
        ]);
    }
}
