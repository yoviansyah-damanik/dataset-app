<?php

namespace App\Http\Controllers;

class RegionController extends Controller
{
    public function index()
    {
        return view('pages.region.index');
    }

    public function district()
    {
        return view('pages.region.district');
    }

    public function village()
    {
        return view('pages.region.village');
    }

    public function tps()
    {
        return view('pages.region.tps');
    }
}
