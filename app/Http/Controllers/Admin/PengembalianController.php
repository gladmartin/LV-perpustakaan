<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Pinjam;
use DataTables;
use App\Buku;
use App\Anggota;
use App\Http\Controllers\Controller;
use App\DetailPinjam;
use Carbon\Carbon;
use App\Peraturan;

class PengembalianController extends Controller
{

    public function json()
    {
        return DataTables::of(Pinjam::status('dikembalikan')->get())
        ->addColumn('no', function() {
            return '';
        })
        ->addColumn('anggota', function(Pinjam $pinjam) {
            return "<a class='text-green' href='". route('anggota.show', $pinjam->anggota->id) ."?rb=sd'>{$pinjam->anggota->nama}</a>";
        })
        ->addColumn('buku', function(Pinjam $pinjam) {
            $return = '';
            foreach ($pinjam->detailPinjam as $value) {
                $buku = Buku::find($value->buku_id);
                $return .= "<p><a class='badge' href='" .route('buku.show',$buku->id). "'>{$buku->judul}</a></p> "; 
            }
            return "$return";
        })
        ->addColumn('petugas', function(Pinjam $pinjam) {
            return "<a class='text-green' href='". route('petugas.show', $pinjam->petugas->id) ."'>{$pinjam->petugas->nama}</a>";
        })
        ->addColumn('opsi', function(Pinjam $pinjam) {
            return "
            <button title='hapus' class='btn btn-danger hapus-pengembalian' type='button' data-id='$pinjam->id'><i class='fa fa-trash'></i></button>
            <a title='detail' href='". route('pinjam.show', $pinjam->id) ."' class='btn btn-dark' data-id='$pinjam->id'><i class='fa fa-eye'></i> </a>";
        })
        ->rawColumns(['opsi', 'anggota', 'petugas', 'buku'])
        ->make(true);
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pengembalian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['anggota'] = Anggota::all();
        return view('pengembalian.create', $data);
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
            'anggota_id' => 'required|exists:pinjam|numeric',
            'buku' => 'required',
            'pinjam_id' => 'required|exists:pinjam,id|numeric'
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'errors' => $validator->errors()
            ];
            return response()->json($response);
        }

        $arrBuku = json_decode($request->buku);
        $jmlPengembalian = count($arrBuku);
        // update table pinjam
        $where = ['id' => $request->pinjam_id, 'anggota_id' => $request->anggota_id];
        $pinjam = Pinjam::where($where)->first();
        if (!$pinjam) {
            $response = [
                'status' => false,
                'msg' => 'pengembalian tidak valid'
            ];
            return response()->json($response);
        }
        // cek jika ada denda
        $peraturan = Peraturan::find($pinjam->peraturan_id);
        $maksPengemblian = $peraturan->lama_pengembalian;
        $biayaDenda = $peraturan->biaya_denda;
        $tglPeminjaman = Carbon::parse($pinjam->tgl_pinjam);
        $tglPengembalian = Carbon::now();
        $selisihTgl = $tglPeminjaman->diffInDays($tglPengembalian);
        
        $pinjam->status = 'dikembalikan';
        $pinjam->tgl_kembali = Carbon::now();
        $pinjam->petugas_id = 1;
        // $pinjam->save();
        // detail pengembalian buku
        $newArrBuku = [];
        foreach ($arrBuku as $key => $buku) {
            $kondisi = ['pinjam_id' => $pinjam->id, 'buku_id' => $buku->id];
            $update = ['keterangan' => $buku->keterangan];
            $newArrBuku[$key]['judul'] = Buku::find($buku->id)->judul; 
            $newArrBuku[$key]['ket'] = $buku->keterangan;
            // DetailPinjam::where($kondisi)->update($update);
        }
        $anggota = Anggota::find($request->anggota_id);
        $response = [
            'status' => true,
            'data' => [
                'anggota' => $anggota->nama,
                'tglPinjam' => $tglPeminjaman,
                'tglKembali' => $tglPengembalian,
                'buku' => $newArrBuku,
                'jmlPengembalian' => $jmlPengembalian,
                'perpustakaan' => [
                    'nama' => identitas()->nama,
                    'alamat' => identitas()->alamat
                ]
            ]
        ];
        if ($selisihTgl > $maksPengemblian)
        {
            $keterlambatan = $selisihTgl - $maksPengemblian;
            $subTotalDendaKeterlambatan = $keterlambatan * $biayaDenda;
            $grandTotalDendaKetlambatan =  $subTotalDendaKeterlambatan * $jmlPengembalian;
            $response['data']['denda'] = [
                'maks' => $maksPengemblian,
                'keterlambatan' => $keterlambatan,
                'biayaDenda' => rupiah($biayaDenda,''),
                'subtotalketerlambatan' => rupiah($subTotalDendaKeterlambatan,''),
                'grandtotalketerlambatan' => rupiah($grandTotalDendaKetlambatan,'')
            ];
            return response()->json($response);
        }
        return response()->json($response);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengemalian = Pinjam::find($id);
        $delete = $pengemalian->delete();
        $response = $delete ? ['status' => true, 'msg' => 'Data berhasil dihapus', 'data' => ''] : ['status' => false, 'msg' => 'Data gagal dihapus'];
        return response()->json($response);
    }
}
