<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\SawHasilController as App;
use App\SawHasil;
use App\SawKriteria;
use App\Lamaran;

class SawHasilController extends App
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hasils = SawHasil::with([
            'lamaran.pelamar.user',
            'lamaran.pekerjaan',
            'sawKriteria',
            'sawHasilDetails.soal',
        ])
        ->whereHas(
            'lamaran', function($query) {
                $query->whereHas(
                    'pelamar', function($query) {
                        $query->where('user_id', \Auth::user()->id);
                    }
                );
            }
        )
        ->get();
        $saw_kriterias = SawKriteria::all();
        // $lamarans = Lamaran::with(
        //     [
        //         'pelamar.user',
        //         'pekerjaan'
        //     ])
        //     ->get();

        return view('pelamar/soal/hasil', compact(
            [
                'hasils',
                'saw_kriterias',
            ]
        ));
    }
}
