<?php

namespace App\Http\Controllers;

use App\Models\Tps;
use App\Models\Voter;
use App\Models\Village;
use App\Models\District;
use App\Exports\VotersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class VoterController extends Controller
{
    public function index()
    {
        return view('pages.voter.index');
    }

    public function create()
    {
        return view('pages.voter.create');
    }

    public function create_family()
    {
        return view('pages.voter.create_family');
    }

    public function show(Voter $voter)
    {

        return view('pages.voter.show', ['voter' => $voter]);
    }

    public function edit(Voter $voter)
    {
        return view('pages.voter.edit', ['voter' => $voter]);
    }

    public function print()
    {
        return view('pages.voter.print');
    }

    public function migration()
    {
        return view('pages.voter.migration');
    }

    public function transfer()
    {
        return view('pages.voter.transfer');
    }

    public function delete(Voter $voter)
    {
        if (!auth()->user()->permissions->some('delete voter'))
            return abort(403, 'Oooppssss..... Mau ngapain kamu!');

        $ktp = $voter->ktp;
        if ($ktp)
            Storage::disk('public')->delete($ktp);

        $kk = $voter->kk;
        if ($kk)
            Storage::disk('public')->delete($kk);

        $voter->delete();

        Alert::toast('Berhasil hapus data pemilih.', 'success');
        return redirect()->route('voters');
    }

    public function tes()
    {
        $team = '035109da-756a-40c1-8507-53ae409233ef';

        Excel::store(new VotersExport(
            team: $team
        ), '/excel/tes.xlsx', 'public');

        $result = Voter::with('dpt', 'dpt.tps')->where('team_id', $team)
            ->get()
            ->map(fn($voter) => [
                'name' => $voter->name,
                'tps' => $voter->dpt->tps->name
            ]);

        return $result;
    }
}
