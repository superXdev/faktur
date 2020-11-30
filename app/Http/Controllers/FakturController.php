<?php

namespace App\Http\Controllers;

use App\Models\Faktur;
use App\Models\Goods;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
class FakturController extends Controller
{
    public function index()
    
    {
        $AWAL = 'ADS';
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
       $noUrutAkhir = DB::table('fakturs')->max('id');
       $no = 1;
       if(date('d') === 1) {
           $ok= "" . sprintf("%03s", $no). '/' . $AWAL .'/' . $bulanRomawi[date('n')] .'/' . date('Y');
       }
       else {
           $ok= "" . sprintf("%03s", abs($noUrutAkhir + 1)). '/' . $AWAL .'/' . $bulanRomawi[date('n')] .'/' . date('Y');
       }
     
        $selectOutlet = Outlet::pluck('namaOutlet', 'id');
        return view('faktur.fakturDex', ['outlet' => $selectOutlet,]);
    }
    

    public function getOutlet($id)
    {
        $all = new Outlet();

        $outlet = $all->where('id', $id)->get();

        return response()->json($outlet);
    }

    public function getJenis($jenis)
    {
        $goodsPrice = DB::table('goods_prices')
        ->join('goods', 'goods_prices.goods_id' ,'=', 'goods.id')
        ->where('jenisOutlet', '=', $jenis)->get();
        
        return response()->json($goodsPrice);
    }

    public function getGoods($goodsId)
    {
        // $goods = DB::table('goods')
        // ->join('goods', 'goods_prices.goods_id' ,'=', 'goods.id')
        // ->where('id', '=', $goodsId)->get();

        $goods = DB::select("SELECT * FROM goods_prices JOIN goods ON goods.id = goods_prices.goods_id where goods.id = '$goodsId'");
        // ddd($goods);
        return response()->json($goods);
    }

 

    public function create(Request $request)
    {
         
      return view('faktur.fakturDex');
    }

    
    public function store(Request $request){ 
        $kodeFaktur = $request->data['head'][0]['kodeFaktur'];
        $outletId = $request->data['head'][0]['outlet'];
        $idd = $request->data['head'][0]['id'];
        $diskon = $request->data['head'][0]['diskon'];
        $grandTotal = $request->data['head'][0]['grandTotal'];
        $tanggal = $request->data['head'][0]['tanggal'];

        // insert fakturs
       $ok= DB::table('fakturs')->insert([
            'id' =>$idd,
            'diskon' =>$diskon,
            'grandTotal' =>$grandTotal,
            'tanggal' =>$tanggal,
            'slug' => Str::kebab(auth()->user()->name).'-'.Str::random(10),
            'namaPengirim' => auth()->user()->name,
            'invoice' => $kodeFaktur,
            'outlet_id' => $outletId
        ]);

            
        $data1 = Faktur::where('invoice', '=', $kodeFaktur)->select('id')->first();

        foreach($request->data['detailData'] as $data){
            DB::table('faktur_barangs')->insert([
                'faktur_id' =>  $idd,
                'idBarang' => $data['id'],
                'qty' => $data['qty'],
                'jumlah_harga' => $data['namaBarang'],
                'HPP' => $data['totalmodal'],
                'laba' => $data['laba']
            ]);
        }

        
        
     }

}
