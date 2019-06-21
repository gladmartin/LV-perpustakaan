<?php

namespace App\Http\Controllers;

use App\Peraturan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeraturanController extends Controller
{

    public function json()
    {
        return DataTables::of(Peraturan::orderBy('status', 'ASC')->get())
        ->addColumn('no', function() {
            return '';
        })
        ->addColumn('petugas', function(Peraturan $peraturan) {
            return "<a href=". route('petugas.show', $peraturan->petugas->id) .">{$peraturan->petugas->nama}</a>";
        })
        ->editColumn('lama_pengembalian', function(Peraturan $peraturan) {
            return "<span class='badge'>$peraturan->lama_pengembalian (hari)</span>";
        })
        ->editColumn('maksimal_peminjaman', function(Peraturan $peraturan) {
            return "<span class='badge'>$peraturan->maksimal_peminjaman (buku)</span>";
        })
        ->editColumn('dispensasi_keterlambatan', function(Peraturan $peraturan) {
            return "<span class='badge'>$peraturan->dispensasi_keterlambatan (hari)</span>";
        })
        ->addColumn('opsi', function(Peraturan $peraturan) {
            return "
            <a href='". route('peraturan.show', $peraturan->id) ."' class='btn btn-dark' data-id='$peraturan->id'><i class='fa fa-eye'></i> </a>";
        })
        ->rawColumns(['opsi', 'petugas', 'lama_pengembalian', 'maksimal_peminjaman', 'dispensasi_keterlambatan'])
        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['peraturan'] = Peraturan::withCount('pinjam')->get();
        return view('peraturan.index', $data);
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
            'lama_pengembalian' => 'required|numeric|min:1', 
            'maks' => 'required|numeric|min:1', 
            'dispensasi' => 'required|numeric', 
            'denda' => 'required|numeric', 
        ]);
        if ($validator->fails())
        {
            $response = [
                'status' => false,
                'errors' => $validator->errors()
            ];
            return response()->json($response);
        }
        // set non-aktif peraturan lama
        Peraturan::where('status', 'aktif')->update(['status' => 'non-aktif']);
        
        $peraturan = new Peraturan();
        $peraturan->lama_pengembalian = $request->lama_pengembalian;
        $peraturan->maksimal_peminjaman = $request->maks;
        $peraturan->dispensasi_keterlambatan = $request->maks;
        $peraturan->biaya_denda = $request->denda;
        $peraturan->status = 'aktif';
        $peraturan->petugas_id = Auth::user()->id;
        $peraturan->save();
        $response = [
            'status' => true,
            'data' => $peraturan
        ];
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Peraturan  $peraturan
     * @return \Illuminate\Http\Response
     */
    public function show(Peraturan $peraturan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Peraturan  $peraturan
     * @return \Illuminate\Http\Response
     */
    public function edit(Peraturan $peraturan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Peraturan  $peraturan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peraturan $peraturan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Peraturan  $peraturan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peraturan $peraturan)
    {
        //
    }
}
