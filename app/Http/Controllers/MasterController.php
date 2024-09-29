<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        return view('pages.master.index');
    }

    public function marital_status()
    {
        return view('pages.master.marital_status');
    }

    public function profession()
    {
        return view('pages.master.profession');
    }

    public function religion()
    {
        return view('pages.master.religion');
    }

    public function nasionality()
    {
        return view('pages.master.nasionality');
    }
}
