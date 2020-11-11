<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    public function index()
    {
        return view('outlet.outletDex');
    }

    public function view()
    {
        return view('outlet.outletView');
    }
}
