<?php

namespace App\Http\Controllers\Admin;

use App\Anggota;
use DataTables;
use File;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnggotaController extends Controller
{

    public function json()
    {
        return DataTables::of(Anggota::all())
        ->addColumn('no', function() {
            return '';
        })
        ->addColumn('email', function(Anggota $anggota) {
            return $anggota->user->email;
        })
        ->editColumn('gambar', function(Anggota $anggota) {
            return '<img src="' .asset('img/avatar') .'/'. getPicture($anggota->user->avatar) .'" width="100">';
        })
        ->addColumn('opsi', function(Anggota $anggota) {
            return "
            <button class='btn btn-danger hapus-anggota' type='button' data-id='$anggota->id'><i class='fa fa-trash'></i></button>
            <a href='". route('anggota.show', $anggota->id) ."' class='btn btn-dark' data-id='$anggota->id'><i class='fa fa-eye'></i> </a>
            <a href='". route('anggota.edit', $anggota->id) ."' class='btn btn-success' data-id='$anggota->id'><i class='fa fa-edit'></i> </a>";
        })
        ->rawColumns(['opsi', 'gambar', 'penerbit', 'pengarang'])
        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('anggota.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|min:3',
            'jk'       => 'required',
            'agama'    => 'required',
            'email'    => 'required|email|unique:users',
            'katasandi' => 'required|min:8',
            'kontak'   => 'required|min:10',
            'avatar'   => 'mimes:jpeg,png,jpg'
        ]);

        $user                 = new User();
        $user->name           = $request->nama;
        $user->email          = $request->email;
        $user->password       = bcrypt($request->katasandi);
        $user->remember_token = str_random(60);    
        $user->role           = 'anggota';
        if ($request->hasFile('avatar'))
        {
            $fileName = str_random(30). "." .$request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move('img/avatar/', $fileName);
            $user->avatar = $fileName;
        }
        $user->save();
        $request->request->set('user_id', $user->id);
        Anggota::create($request->all());
        return redirect(route('anggota.index'))->with('info', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anggota = Anggota::findorFail($id);
        $data['anggota'] = $anggota;
        return view('anggota.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anggota = Anggota::findorFail($id);
        $data['anggota'] = $anggota;
        $data['agama'] = ['Islam', 'Kristen', 'Budha', 'Kongochu'];
        return view('anggota.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $anggota = Anggota::findorFail($id);
        $request->validate([
            'nama'     => 'required|min:3',
            'jk'       => 'required',
            'agama'    => 'required',
            'kontak'   => 'required|min:10',
            'avatar'   => 'mimes:jpeg,png,jpg'
        ]);
        $user = User::findorFail($anggota->user_id);
        $user->name = $request->nama;
        if ($request->hasFile('avatar'))
        {
            File::delete("img/avatar/{$user->avatar}");
            $fileName = str_random(30). "." .$request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move('img/avatar/', $fileName);
            $user->avatar = $fileName;
        }
        $user->save();
        $anggota->update($request->all());
        return redirect(route('anggota.index'))->with('info', 'Data berhasil diuba');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anggota = Anggota::find($id);
        $user = User::find($anggota->user_id);
        File::delete("img/avatar/{$user->avatar}");
        $delete = $user->delete();
        $response = $delete ? ['status' => true, 'msg' => 'Data berhasil dihapus', 'data' => $user] : ['status' => false, 'msg' => 'Data gagal dihapus'];
        return response()->json($response);
    }
}
