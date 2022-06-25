<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\LamaranController as App;
use App\Lamaran;
use App\Pekerjaan;
use App\Pelamar;
use App\SawKriteria;

class LamaranController extends App
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lamarans = Lamaran::with(
            [
                'pelamar',
                'pekerjaan',
                'sawHasils',
            ])
            ->where('pelamar_id', \Auth::user()->pelamar->id)
            ->get();
        $pelamars = Pelamar::with(['user'])
            ->where('id', \Auth::user()->pelamar->id)
            ->get();
        $pekerjaans = Pekerjaan::all();
        $kriterias = SawKriteria::all();

        return view('lamaran/index-pelamar', compact([
            'lamarans',
            'pelamars',
            'pekerjaans',
            'kriterias',
        ]));
    }

    /**
     * Display a listing of the hasil resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hasil()
    {
        $lamarans = Lamaran::with(
            [
                'pekerjaan',
                'diterimaOleh'
            ])
            ->where('diverifikasi', true)
            ->whereHas(
                'pelamar', function($query) {
                    $query->where('user_id', \Auth::user()->id);
                }
            )
            ->get();

        return view('lamaran/hasil-pelamar', compact([
            'lamarans',
        ]));
    }
}
