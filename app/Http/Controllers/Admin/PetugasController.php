<?php

namespace App\Http\Controllers\Admin;

use App\Petugas;
use App\User;
use File;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PetugasExport;
use App\Imports\PetugasImport;

class PetugasController extends Controller
{

    public function json()
    {
        return DataTables::of(Petugas::where('user_id', '!=', Auth::user()->id)->get())
        ->addColumn('no', function() {
            return '';
        })
        ->addColumn('email', function(Petugas $petugas) {
            return $petugas->user->email;
        })
        ->editColumn('gambar', function(Petugas $petugas) {
            return '<img src="' .asset('img/avatar') .'/'. getPicture($petugas->user->avatar) .'" width="100">';
        })
        ->addColumn('opsi', function(Petugas $petugas) {
            return "
            <button title='hapus' class='btn btn-danger hapus-petugas' type='button' data-id='$petugas->id'><i class='fa fa-trash'></i></button>
            <a title='detail' href='". route('petugas.show', $petugas->id) ."' class='btn btn-dark' data-id='$petugas->id'><i class='fa fa-eye'></i> </a>";
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
        $data['petugas'] = Petugas::all();
        return view('petugas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['agama'] = ['Islam', 'Kristen', 'Budha', 'Kongochu'];
        return view('petugas.create', $data);
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
            'avatar'   => 'mimes:jpeg,png'
        ]);

        $user                 = new User();
        $user->name           = $request->nama;
        $user->email          = $request->email;
        $user->password       = bcrypt($request->katasandi);
        $user->remember_token = str_random(60);    
        $user->role           = 'petugas';
        if ($request->hasFile('foto'))
        {
            $fileName = str_random(30). "." .$request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move('img/avatar/', $fileName);
            $user->avatar = $fileName;
        }
        $user->save();
        $request->request->set('user_id', $user->id);
        Petugas::create($request->all());
        return redirect(route('petugas.index'))->with('success', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $petugas = Petugas::findorFail($id);
        $data['petugas'] = $petugas;
        return view('petugas.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $petugas = Petugas::findorFail($id);
        $data['petugas'] = $petugas;
        $data['agama'] = ['Islam', 'Kristen', 'Budha', 'Kongochu'];
        return view('petugas.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, petugas $petugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $petugas = Petugas::find($id);
        $user = User::find($petugas->user_id);
        File::delete("img/avatar/{$user->avatar}");
        $delete = $user->delete();
        $response = $delete ? ['status' => true, 'msg' => 'Data berhasil dihapus', 'data' => $user] : ['status' => false, 'msg' => 'Data gagal dihapus'];

        return response()->json($response);
    }

    public function exportPdf()
    {
        $data['petugas'] = Petugas::with('user')->get();
        $pdf = PDF::loadView('export.pdf.petugas', $data);

        return $pdf->download('daftar-data-petugas.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PetugasExport, 'daftar-data-petugas.xlsx');
    }

    public function import() 
    {
        Excel::import(new PetugasImport, public_path('daftar-data-petugas.xlsx'));
        
        return redirect('/')->with('success', 'All good!');
    }
}
