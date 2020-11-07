<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
