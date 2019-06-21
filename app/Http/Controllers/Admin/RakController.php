<?php

namespace App\Http\Controllers\Admin;

use App\Rak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class RakController extends Controller
{

    public function json()
    {
        return DataTables::of(Rak::withCount('buku')->get())
        ->addColumn('no', function() {
            return '';
        })
        ->addColumn('opsi', function($arrrak) {
            return "<button class='btn btn-danger hapus-rak' type='button' data-id='$arrrak->id'><i class='fa fa-trash'></i></button>
            <a data-toggle='modal' data-target='.bs-example-modal-sm' class='btn btn-success ubah-rak' data-id='$arrrak->id'><i class='fa fa-edit'></i> </a>";
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
        return view('rak.index');
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
            'nama' => 'required|min:2|max:50|unique:rak'
        ])
        ->setAttributeNames([
            'nama' => 'Rak'
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
        $rak = rak::create($request->all());
        $response = [
            'status' => true,
            'data' => $rak
        ];
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function show(Rak $rak)
    {
        if (!$rak) $response = ['status' => false, 'msg' => 'no data found'];
        $response = ['status' => true, 'data' => $rak];
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rak $rak)
    {
        $validator = \Validator::make($request->all(), [
            'nama' => 'required|min:2|max:50|unique:rak'
        ])
        ->setAttributeNames([
            'nama' => 'Rak'
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
        $rak->update($request->all());
        $response = [
            'status' => true,
            'data' => $rak
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rak $rak)
    {        
        $delete = $rak->delete();
        $response = $delete ? ['status' => true, 'msg' => 'Data berhasil dihapus', 'data' => $rak] : ['status' => false, 'msg' => 'Data gagal dihapus'];
        return response()->json($response);
    }
}
