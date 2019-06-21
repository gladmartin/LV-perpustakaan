<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Identitas;
use Validator;
use File;

class IdentitasController extends Controller
{
    public function index()
    {
        $identitas = Identitas::get()->first();
        $data['identitas'] = $identitas;
        return view('identitas.index', $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_perpustakaan' => 'required|min:5', 
            'email' => 'required|email', 
            'alamat' => 'required|min:5', 
            'telp' => 'required', 
            'logo' => 'image', 
            'icon' => 'image', 
        ]);
        if ($validator->fails())
        {
            $response = [
                'status' => false,
                'errors' => $validator->errors()
            ];
            return response()->json($response);
        }
        
        $identitas = Identitas::get()->first();
        $identitas->nama = $request->nama_perpustakaan;
        $identitas->email = $request->email;
        $identitas->telp = $request->telp;
        $identitas->alamat = $request->alamat;
        if ($request->hasFile('logo'))
        {
            $logo = str_random(30) .".". $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move('img/', $logo);
            File::delete("img/{$identitas->logo}");
            $identitas->logo = $logo;
        }
        if ($request->hasFile('icon'))
        {
            $icon = str_random(30) .".". $request->file('icon')->getClientOriginalExtension();
            $request->file('icon')->move('img/', $icon);
            File::delete("img/{$identitas->icon}");
            $identitas->icon = $icon;
        }
        $identitas->save();
        $response = [
            'status' => true,
            'data' => $identitas
        ];
        return response()->json($response);
    }
}
