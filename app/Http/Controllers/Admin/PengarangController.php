<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pengarang;
use App\Buku;
use DataTables;
use File;

class PengarangController extends Controller
{
    public function json()
    {
        return DataTables::of(Pengarang::withCount('buku')->get())
        ->addColumn('no', function() {
            return '';
        })
        ->editColumn('gambar', function(Pengarang $pengarang) {
            return '<img src="' .asset('img/pengarang') .'/'. getPicture($pengarang->gambar) .'" width="50">';
        })
        ->addColumn('opsi', function($arrPengarang) {
            return "<button class='btn btn-danger hapus-pengarang' type='button' data-id='$arrPengarang->id'><i class='fa fa-trash'></i></button>
            <a data-toggle='modal' data-target='.bs-example-modal-sm' class='btn btn-success ubah-pengarang' data-id='$arrPengarang->id'><i class='fa fa-edit'></i> </a>";
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
        $data['pengarang'] = Pengarang::withCount('buku')->get();
        return view('pengarang.index', $data);
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
            'nama' => ['required','min:2','max:50'],            
            'foto'   => 'image'
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
            $request->file('foto')->move('img/pengarang/', $fileName);
            $request->request->set('gambar', $fileName);
        }
        $pengarang = Pengarang::create($request->all());
        $response = [
            'status' => true,
            'data' => $pengarang
        ];
        return response()->json($response);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pengarang $pengarang)
    {
        if (!$pengarang) $response = ['status' => false, 'msg' => 'no data found'];
        $response = ['status' => true, 'data' => $pengarang];
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengarang $pengarang)
    {
        $validator = \Validator::make($request->all(), [
            'nama' => ['required','min:2','max:50'],            
            'foto'   => 'image'
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
            $request->file('foto')->move('img/pengarang/', $fileName);
            $request->request->set('gambar', $fileName);
            File::delete("img/pengarang/{$pengarang->gambar}");
        }
        $pengarang->update($request->all());
        $response = [
            'status' => true,
            'data' => $pengarang
        ];
        return response()->json($response);     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengarang $pengarang)
    {
        $bukuPengarang = Buku::where('pengarang_id', $pengarang->id)->get();
        if ($bukuPengarang->count() > 0)
        {
            $response = [
                'status' => false,
                'msg' => 'Data pengarang masih digunakan oleh data buku'
            ];
            return response()->json($response);
        }
        File::delete("img/pengarang/{$pengarang->gambar}");
        $delete = $pengarang->delete();
        $response = $delete ? ['status' => true, 'msg' => 'Data berhasil dihapus', 'data' => $pengarang] : ['status' => false, 'msg' => 'Data gagal dihapus'];
        return response()->json($response);
    }
}
