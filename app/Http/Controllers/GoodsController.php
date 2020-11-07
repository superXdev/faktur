<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class GoodsController extends Controller
{
    public function index()
    {
        return view('barang.barangDex');
    }

    public function getGoods()
    {
        return Datatables::of(Goods::query())
            ->editColumn('hargaModal', function ($harga){
                return "Rp. ".number_format($harga->hargaModal, 0, ',', '.')."";
            })
            ->addColumn('lihat', function($data) {
                return "<a class='btn btn-sm btn-info' href='".route('barang.view', $data->slug)."'>Lihat</a>";
            })
            ->rawColumns(['lihat'])
            ->make(true);
    }

    public function create()
    {
        return view('barang.barangCre');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodeBarang' => 'required|unique:goods',
            'namaBarang' => 'required',
            'hargaModal' => 'required',
            'minStok' => 'required',
            'satuan' => 'required'
        ]);

        $form_data = array(
            'slug' => Str::kebab($request->namaBarang).'-'.Str::random(10),
            'kodeBarang' => $request->kodeBarang,
            'namaBarang' => $request->namaBarang,
            'hargaModal' => $request->hargaModal,
            'minStok' => $request->minStok,
            'satuan' => $request->satuan
        );

        Goods::create($form_data);

        $slug = DB::table('goods')->select('slug')->where('kodeBarang', '=', $request->kodeBarang)->first();
        toast('Barang ditambahkan!','success')->position('top-end');
        return redirect()->route('barang.view', $slug->slug);
    }

    public function view($slug)
    {
        $data = Goods::where('slug', $slug)->firstOrFail();
        return view('barang.barangView', compact('data'));
    }

    public function edit($slug)
    {
        $data = Goods::where('slug', '=', $slug)->first();
        return view('barang.barangEdit', compact('data'));
    }

    public function update(Request $request, $slug)
    {
        $form_data = array(
            'slug' => Str::kebab($request->namaBarang).'-'.Str::random(10),
            'kodeBarang' => $request->kodeBarang,
            'namaBarang' => $request->namaBarang,
            'hargaModal' => $request->hargaModal,
            'minStok' => $request->minStok,
            'satuan' => $request->satuan
        );

        Goods::where('slug', $slug)->update($form_data);
        $slugNew = DB::table('goods')->select('slug')->where('kodeBarang', '=', $request->kodeBarang)->first();
        toast('Barang berhasil di perbarui!','success')->position('top-end');
        return redirect()->route('barang.view', $slugNew->slug);
    }
}
