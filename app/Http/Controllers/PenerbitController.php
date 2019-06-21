<?php

namespace App\Http\Controllers\Admin;

use App\Penerbit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Buku;
use DataTables;
use App\Scope\LatestScope;
use File;

class PenerbitController extends Controller
{

    public function json()
    {
        return DataTables::of(Penerbit::withCount('buku')->get())
        ->addColumn('no', function() {
            return '';
        })
        ->editColumn('gambar', function(Penerbit $penerbit) {
            return '<img src="' .asset('img/penerbit') .'/'. getPicture($penerbit->gambar) .'" width="50">';
        })
        ->addColumn('opsi', function($arrpenerbit) {
            return "<button class='btn btn-danger hapus-penerbit' type='button' data-id='$arrpenerbit->id'><i class='fa fa-trash'></i></button>
            <a data-toggle='modal' data-target='.bs-example-modal-sm' class='btn btn-success ubah-penerbit' data-id='$arrpenerbit->id'><i class='fa fa-edit'></i> </a>";
        })
        ->rawColumns(['opsi', 'gambar'])
        ->make(true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('penerbit.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nama' => 'required|min:2|max:50',            
            'foto'   => 'mimes:jpeg,png'
        ]);
        if ($validator->fails())
        {
            $response = [
                'status' => false,
                'errors' => [
                    'nama' => $validator->errors()->first('nama'),
                    'foto' => $validator->errors()->first('foto'),
                ]
            ];
            return response()->json($response);
        }
        if ($request->hasFile('foto'))
        {
            $fileName = str_random(30). "." .$request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move('img/penerbit/', $fileName);
            $request->set('gambar', $fileName);
        }
        $penerbit = Penerbit::create($request->all());
        $response = [
            'status' => true,
            'data' => $penerbit
        ];
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Penerbit  $penerbit
     * @return \Illuminate\Http\Response
     */
    public function show(Penerbit $penerbit)
    {
        if (!$penerbit) $response = ['status' => false, 'msg' => 'no data found'];
        $response = ['status' => true, 'data' => $penerbit];
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penerbit  $penerbit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penerbit $penerbit)
    {
        $validator = \Validator::make($request->all(), [
            'nama' => 'required|min:2|max:50',            
            'foto'   => 'mimes:jpeg,png'
        ]);
        if ($validator->fails())
        {
            $response = [
                'status' => false,
                'errors' => [
                    'nama' => $validator->errors()->first('nama'),
                    'foto' => $validator->errors()->first('foto'),
                ]
            ];
            return response()->json($response);
        }
        if ($request->hasFile('foto'))
        {
            $fileName = str_random(30). "." .$request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move('img/penerbit/', $fileName);
            $request->request->set('gambar', $fileName);
            File::delete("img/penerbit/{$penerbit->gambar}");
        }
        $penerbit->update($request->all());
        $response = [
            'status' => true,
            'data' => $penerbit
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penerbit  $penerbit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penerbit $penerbit)
    {
        $bukuPenerbit = Buku::where('penerbit_id', $penerbit->id)->get();
        if ($bukuPenerbit->count() > 0)
        {
            $response = [
                'status' => false,
                'msg' => 'Data penerbit masih digunakan oleh data buku'
            ];
            return response()->json($response);
        }
        File::delete("img/penerbit/{$penerbit->gambar}");
        $delete = $penerbit->delete();
        $response = $delete ? ['status' => true, 'msg' => 'Data berhasil dihapus', 'data' => $penerbit] : ['status' => false, 'msg' => 'Data gagal dihapus'];
        return response()->json($response);
    }
}
