<?php

namespace App\Http\Controllers;

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
}
