<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanController extends Controller
{
    //

    public function index(Request $req)
    {
        
        $goods = DB::table('outlets')->get();

        $from = $req->input('jenisOutlet');
            $to   = $req->input('periode');
            if ($req->has('search'))
            {
                // select search
                $ViewsPage = DB::select("SELECT outlets.namaOutlet,fakturs.invoice,fakturs.grandTotal,faktur_barangs.laba,faktur_barangs.HPP FROM outlets JOIN fakturs ON fakturs.outlet_id = outlets.id
                JOIN faktur_barangs ON faktur_barangs.faktur_id = fakturs.invoice
                JOIN goods ON goods.id = faktur_barangs.idBarang where namaOutlet='$from' order by fakturs.created_at asc");
                return view('laporan.laporanView',compact('ViewsPage'), ['outlet' => $goods]);
            }elseif ($req->has('exportPDF'))
            {
                // select PDF
                $PDFReport = DB::select("SELECT outlets.namaOutlet,fakturs.invoice,fakturs.grandTotal,faktur_barangs.laba,faktur_barangs.HPP FROM outlets JOIN fakturs ON fakturs.outlet_id = outlets.id
                JOIN faktur_barangs ON faktur_barangs.faktur_id = fakturs.invoice
                JOIN goods ON goods.id = faktur_barangs.idBarang where namaOutlet='$from' order by fakturs.created_at asc");
                
                 view()->share('users',$PDFReport);  
                
                
                // $pdf = PDF::loadView('PDF_report', ['PDFReport' => $PDFReport])->setPaper('a4', 'landscape');
                // return $pdf->download('PDF-report.pdf');
            }  
        else
        {
            $ViewsPage = DB::select('SELECT outlets.namaOutlet,fakturs.invoice,fakturs.grandTotal,faktur_barangs.laba,faktur_barangs.HPP FROM outlets JOIN fakturs ON fakturs.outlet_id = outlets.id
            JOIN faktur_barangs ON faktur_barangs.faktur_id = fakturs.invoice
            JOIN goods ON goods.id = faktur_barangs.idBarang order by fakturs.created_at asc');

            return view('laporan.laporanView',compact('ViewsPage'), ['outlet' => $goods]);
            }
    }

     
    
}
