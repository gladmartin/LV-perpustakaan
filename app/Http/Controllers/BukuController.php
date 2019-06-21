<?php

namespace App\Http\Controllers;

use App\Buku;
use App\Rak;
use App\Pengarang;
use App\Penerbit;
use App\Kategori;
use DataTables;
use File;
use Illuminate\Http\Request;

class BukuController extends Controller
{

    public function json()
    {
        return DataTables::of(Buku::orderBy('buku.created_at', 'desc')->get())
        ->addColumn('no', function() {
            return '';
        })
        ->addColumn('pengarang', function(Buku $buku) {
            return "<a href=". route('pengarang.show', $buku->pengarang->id) .">{$buku->pengarang->nama}</a>";
        })
        ->addColumn('penerbit', function(Buku $buku) {
            return "<a href=". route('penerbit.show', $buku->penerbit->id) .">{$buku->penerbit->nama}</a>";
        })
        ->addColumn('kategori', function(Buku $buku) {
            return "{$buku->kategori->nama}";
        })
        ->addColumn('rak', function(Buku $buku) {
            return "{$buku->rak->nama}";
        })
        ->editColumn('gambar', function(Buku $buku) {
            return '<img src="' .asset('img/buku') .'/'. getPicture($buku->cover, 'no-pict.png') .'" width="100">';
        })
        ->addColumn('opsi', function(Buku $buku) {
            return "
            <button title='hapus' class='btn btn-danger hapus-buku' type='button' data-id='$buku->id'><i class='fa fa-trash'></i></button>
            <a title='detail' href='". route('buku.show', $buku->id) ."' class='btn btn-dark' data-id='$buku->id'><i class='fa fa-eye'></i> </a>
            <a title='edit' href='". route('buku.edit', $buku->id) ."' class='btn btn-success' data-id='$buku->id'><i class='fa fa-edit'></i> </a>";
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
        return view('buku.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['rak'] = Rak::all();
        $data['pengarang'] = Pengarang::all();
        $data['penerbit'] = Penerbit::all();
        $data['kategori'] = Kategori::all();
        return view('buku.create', $data);
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
            'judul'        => 'required|min:3',
            'isbn'         => 'required',
            'rak_id'       => 'required|exists:rak,id',
            'pengarang_id' => 'required|numeric|exists:pengarang,id',
            'penerbit_id'  => 'required|numeric|exists:penerbit,id',
            'kategori_id'  => 'required|numeric|exists:kategori,id',
            'deskripsi'    => 'required',
            'stok'         => 'required|numeric',
            'tahun_terbit' => 'required|numeric',
            'foto'         => 'mimes:jpeg,png'
        ]);
        if ($request->hasFile('foto'))
        {
            $fileName = str_random(30). "." .$request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move('img/buku/', $fileName);
            $request->request->set('cover', $fileName);
        }
        Buku::create($request->all());
        return redirect(route('buku.index'))->with('info', 'Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function show(Buku $buku)
    {
        $data['buku'] = $buku;
        return view('buku.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function edit(Buku $buku)
    {
        $data['buku'] = $buku;
        $data['rak'] = Rak::all();
        $data['pengarang'] = Pengarang::all();
        $data['penerbit'] = Penerbit::all();
        $data['kategori'] = Kategori::all();
        return view('buku.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul'     => 'required|min:3',
            'isbn'       => 'required',
            'rak_id'    => 'required',
            'pengarang_id'    => 'required|numeric',
            'penerbit_id' => 'required|numeric',
            'kategori_id' => 'required|numeric',
            'deskripsi' => 'required',
            'stok'   => 'required|numeric',
            'tahun_terbit'   => 'required|numeric',
            'foto'   => 'mimes:jpeg,png'
        ]);
        if ($request->hasFile('foto'))
        {
            $fileName = str_random(30). "." .$request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move('img/buku/', $fileName);
            $request->request->set('cover', $fileName);
        }
       $buku->update($request->all());
        return redirect(route('buku.index'))->with('info', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buku $buku)
    {
        File::delete("img/buku/{$buku->cover}");
        $delete = $buku->delete();
        $response = $delete ? ['status' => true, 'msg' => 'Data berhasil dihapus', 'data' => $buku] : ['status' => false, 'msg' => 'Data gagal dihapus'];
        return response()->json($response);
    }

}
