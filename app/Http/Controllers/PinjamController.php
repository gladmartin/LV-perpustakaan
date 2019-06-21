<?php

namespace App\Http\Controllers;

use App\Pinjam;
use App\Buku;
use App\Peraturan;
use DataTables;
use Illuminate\Http\Request;
use App\Anggota;
use Illuminate\Support\Facades\Auth;
use App\DetailPinjam;
use Carbon\Carbon;

class PinjamController extends Controller
{

    public function json()
    {
        return DataTables::of(Pinjam::status('dipinjam')->orderBy('tgl_pinjam', 'desc')->get())
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
            <button title='hapus' class='btn btn-danger hapus-pinjam' type='button' data-id='$pinjam->id'><i class='fa fa-trash'></i></button>
            <a title='detail' href='". route('pinjam.show', $pinjam->id) ."' class='btn btn-dark' data-id='$pinjam->id'><i class='fa fa-eye'></i> </a>";
        })
        ->rawColumns(['opsi', 'anggota', 'petugas', 'buku'])
        ->make(true);
    }

    public function jsonAnggota()
    {
        return DataTables::of(Pinjam::PinjamanSaya()->latest('tgl_pinjam')->get())
        ->addColumn('buku', function(Pinjam $pinjam) {
            $return = '';
            foreach ($pinjam->detailPinjam as $value) {
                $buku = Buku::find($value->buku_id);
                $return .= "<p><a class='badge' href='" .route('buku.show',$buku->id). "'>{$buku->judul}</a></p> "; 
            }
            return $return;
        })
        ->addColumn('petugas', function(Pinjam $pinjam) {
            return "<a class='text-green' href='". route('petugas.show', $pinjam->petugas->id) ."'>{$pinjam->petugas->nama}</a>";
        })
        ->addColumn('opsi', function(Pinjam $pinjam) {
            return "
            <a title='detail' href='". route('pinjam.show', $pinjam->id) ."' class='btn btn-dark' data-id='$pinjam->id'><i class='fa fa-eye'></i> </a>";
        })
        ->rawColumns(['opsi', 'petugas', 'buku'])
        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pinjam.index');
    }

    public function indexAnggota()
    {
        return view('pinjam.list-pinjam-anggota');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['anggota'] = Anggota::all();
        $data['buku'] = Buku::all();
        $data['peraturan'] = Peraturan::active()->first();
        return view('pinjam.create', $data);
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
            'anggota' => ['required','numeric','exists:anggota,id'],
            'buku' => 'required'
        ]);

        if($validator->fails())
        {
            $response = [
                'status' => false,
                'errors' => $validator->errors()
            ];
            return response()->json($response);
        } 

        // cek apakah id buku yang dikirm berupa array
        $arrBuku = json_decode($request->buku);
        $arrBuku = array_unique($arrBuku);
        if(! is_array($arrBuku) OR empty($arrBuku))
        {
            $response = [
                'status' => false,
                'errors' => 'Buku yang dipilih tidak valid, silahkan refresh halaman!'
            ];
            return response()->json($response);
        }

        // cek apakah id buku tersedia di table 
        foreach ($arrBuku as $value) {
            if(! $buku = Buku::find($value))
            {
                $response = [
                    'status' => false,
                    'errors' => 'Buku yang anda masukkan tidak ditemukan lagi'
                ];
                return response()->json($response);
            }
        }

        // peraturan aktif
        $peraturan = Peraturan::active()->first();
        // ambil semua data
        $anggota = Anggota::find($request->anggota);
        // cek jumlah peminjaman anggota < dari maksimal pemminjaman di table peraturan
        if (count($arrBuku) > $peraturan->maksimal_peminjaman)
        {
            $response = [
                'status' => false,
                'errors' => 'maks peminjaman',
                'data' => [
                    'anggota' => $anggota->nama,
                    'anggotaId' => $anggota->id,
                    'pinjaman' => 0,
                    'dipinjam' => count($arrBuku),
                    'maksimal' => $peraturan->maksimal_peminjaman,
                ]
            ];
            return response()->json($response);
        }

        // cek jumlah peminjaman anggota yang belum dikembalikan < dari maksimal pemminjaman di table peraturan
        $peminjamanAnggota = Pinjam::where(['anggota_id' => $request->anggota, 'status' => 'dipinjam'])->withCount('detailPinjam')->get();
        if(! $peminjamanAnggota->isEmpty())
        {
            $peminjamanAnggotaSebelumnya = 0;
            foreach ($peminjamanAnggota as $item) {
                $peminjamanAnggotaSebelumnya += $item->detail_pinjam_count;
            }
            $peminjamanAnggotaBaru = count($arrBuku);
            $totalPeminjamanAnggota = $peminjamanAnggotaSebelumnya + $peminjamanAnggotaBaru;
            if($totalPeminjamanAnggota > $peraturan->maksimal_peminjaman)
            {
                $response = [
                    'status' => false,
                    'errors' => 'maks peminjaman',
                    'data' => [
                        'anggota' => $anggota->nama,
                        'anggotaId' => $anggota->id,
                        'pinjaman' => $peminjamanAnggotaSebelumnya,
                        'dipinjam' => $peminjamanAnggotaBaru,
                        'maksimal' => $peraturan->maksimal_peminjaman,
                    ]
                ];
                return response()->json($response);
            }
        }
        
        // sukses validasi
        $pinjam = new Pinjam();
        $pinjam->anggota_id = $request->anggota;
        $pinjam->status = 'dipinjam';
        $pinjam->peraturan_id = $peraturan->id;
        $pinjam->petugas_id = Auth::user()->id;
        $pinjam->save();
        // detail pinjam
        $bukuRecord = [];
        foreach ($arrBuku as $b) {
            $bukuRecord[] = [
                'pinjam_id' => $pinjam->id,
                'buku_id' => $b
            ];
        }
        DetailPinjam::insert($bukuRecord);
        $response = [
            'status' => true,
            'data' => $pinjam
        ];
        return response()->json($response);        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function show(Pinjam $pinjam)
    {
        $data['pinjam'] = $pinjam;
        return view('pinjam.detail', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pinjam  $pinjam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pinjam $pinjam)
    {
        $delete = $pinjam->delete();
        $response = $delete ? ['status' => true, 'msg' => 'Data berhasil dihapus', 'data' => $pinjam] : ['status' => false, 'msg' => 'Data gagal dihapus'];
        return response()->json($response);
    }

    public function getListBook($bukuId, $anggotaId = null)
    {
        $buku = Buku::find($bukuId);
        if(! $buku)
        {
            $response = [
                'status' => false,
                'msg' => 'tidak ada buku'
            ];
            return response()->json($response);
        }
        $data = [
            'judul' => $buku->judul,
            'penerbit' => $buku->penerbit->nama,
            'kategori' => $buku->kategori->nama,
            'pengarang' => $buku->pengarang->nama,
            'cover' => asset('img/buku') ."/" . getPicture($buku->cover, 'no-pict.png')
        ];
        $response = [
            'status' => true,
            'data' => $data
        ];
        return response()->json($response);
    }

    public function getByAnggotaId($id)
    {
        $anggota = Anggota::find($id);
        $peminjaman = Pinjam::status('dipinjam')->getByAnggotaId($id)->first();
        if (!$anggota) 
        {
            $response = [
                'status' => false,
                'msg' => "Data anggota tidak ditemukan"
            ];
            return response()->json($response);
        }
        if (!$peminjaman) 
        {
            $response = [
                'status' => false,
                'msg' => "{$anggota->nama} tidak memiliki peminjaman buku"
            ];
            return response()->json($response);
        }
        $bukuPinjaman = [];
        foreach ($peminjaman->detailPinjam as $key => $value) {
            $bukuPinjaman[$key]['id'] = $value->buku->id;
            $bukuPinjaman[$key]['judul'] = $value->buku->judul;
            $bukuPinjaman[$key]['cover'] = asset('img/buku') ."/". getPicture($value->buku->cover, 'no-pict.png');
            $bukuPinjaman[$key]['pengarang'] = $value->buku->pengarang->nama;
        }
        // dd($bukuPinjaman);
        $response = [
            'status' => true,
            'data' => [
                'anggota' => [
                    'id' => $peminjaman->anggota->id,
                    'nama' => $peminjaman->anggota->nama
                ],
                'buku' => $bukuPinjaman,
                'pinjam' => [
                    'id' => $peminjaman->id,
                    'tgl_pinjam' => $peminjaman->tgl_pinjam,
                ],
                'petugas' => [
                    'id' =>  $peminjaman->petugas->id,
                    'nama' =>  $peminjaman->petugas->nama,
                ]
            ]
        ];
        return response()->json($response);
    }

}
