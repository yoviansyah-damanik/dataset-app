<?php

namespace App\Http\Controllers;

use App\Jobs\Dpt;
use App\Jobs\Coordinator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ConfigurationController extends Controller
{
    public function general()
    {
        return view('pages.configuration.general');
    }

    public function log_activity()
    {
        return view('pages.configuration.activity');
    }

    public function load_data(Request $request)
    {
        dispatch(new Coordinator());
        dispatch(new Dpt());

        Alert::toast('Data sedang ditambahkan. Proses berjalan di latar belakang sistem.', 'success');
        return to_route('users');
    }
}
