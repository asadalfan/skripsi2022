<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\PekerjaanController as App;
use App\Lamaran;
use App\Perusahaan;
use App\Pekerjaan;
use App\Tag;
use Illuminate\Support\Facades\Auth;

class PekerjaanController extends App
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perusahaans = Perusahaan::all();
        $lamarans = Lamaran::where('pelamar_id', Auth::user()->pelamar->id)->get('pekerjaan_id');
        $pekerjaanIds = [];
        foreach ($lamarans as $lamaran) {
            array_push($pekerjaanIds, $lamaran->pekerjaan_id);
        }
        $pekerjaans = Pekerjaan::whereNotIn('id', $pekerjaanIds)
            ->orderBy('created_at', 'desc')
            ->get();
        $tags = Tag::all();

        return view('pekerjaan/index-pelamar', compact(['perusahaans', 'pekerjaans', 'tags']));
    }
}
