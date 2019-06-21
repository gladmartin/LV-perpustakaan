<?php

namespace App\Http\Controllers\Admin;

use App\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class KategoriController extends Controller
{

    public function json()
    {
        return DataTables::of(Kategori::withCount('buku')->get())
        ->addColumn('no', function() {
            return '';
        })
        ->addColumn('opsi', function($arrkategori) {
            return "<button class='btn btn-danger hapus-kategori' type='button' data-id='$arrkategori->id'><i class='fa fa-trash'></i></button>
            <a data-toggle='modal' data-target='.bs-example-modal-sm' class='btn btn-success ubah-kategori' data-id='$arrkategori->id'><i class='fa fa-edit'></i> </a>";
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['kategori'] = Kategori::withCount('buku')->get();
        return view('kategori.index', $data);
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
            'nama' => 'required|min:2|max:50|unique:kategori'
        ])
        ->setAttributeNames([
            'nama' => 'Kategori'
        ]);
        if ($validator->fails())
        {
            $response = [
                'status' => false,
                'errors' => [
                    'nama' => $validator->errors()->first('nama'),
                ]
            ];
            return response()->json($response);
        } 
        $kategori = new Kategori();
        $slug = str_slug($request->nama, '-');
        $kategori->nama = $request->nama;
        $kategori->slug = $slug;
        $kategori->save();
        $response = [
            'status' => true,
            'data' => $kategori
        ];
        return response()->json($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        if (!$kategori) $response = ['status' => false, 'msg' => 'no data found'];
        $response = ['status' => true, 'data' => $kategori];
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validator = \Validator::make($request->all(), [
            'nama' => 'required|min:2|max:50|unique:kategori'
        ])
        ->setAttributeNames([
            'nama' => 'Kategori'
        ]);
        if ($validator->fails())
        {
            $response = [
                'status' => false,
                'errors' => [
                    'nama' => $validator->errors()->first('nama'),
                ]
            ];
            return response()->json($response);
        } 
        $slug = str_slug($request->nama, '-');
        $kategori->nama = $request->nama;
        $kategori->slug = $slug;
        $kategori->save();
        $response = [
            'status' => true,
            'data' => $kategori
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {        
        $delete = $kategori->delete();
        $response = $delete ? ['status' => true, 'msg' => 'Data berhasil dihapus', 'data' => $kategori] : ['status' => false, 'msg' => 'Data gagal dihapus'];
        return response()->json($response);

    }
}
