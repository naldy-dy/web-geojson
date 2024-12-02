<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeoJsonData;

class JsonController extends Controller
{
    function index(){
        $data['list_desa'] = GeoJsonData::all();
        return view('index',$data);
    }
    function create(Request $request){
        $request->validate([
            'geojson_file' => 'required|mimes:geojson,json|max:10240',
        ]);

        $file = $request->file('geojson_file');
        $path = $file->storeAs('geojson', $file->getClientOriginalName(), 'public');
        
        $fileContents = file_get_contents(storage_path('app/public/' . $path));
        $geojsonData = json_decode($fileContents, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors('File yang di-upload bukan format GeoJSON yang valid.');
        }

        GeoJsonData::create([
            'geojson' => $geojsonData,  
        ]);

        return back()->with('success', 'File GeoJSON berhasil di-upload dan disimpan ke database!');
    }
}
