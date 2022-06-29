<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\SawHasilController as App;
use App\Fuzzy;
use App\SawHasil;
use App\SawKriteria;
use App\Lamaran;
use App\SawPeringkat;
use Illuminate\Support\Facades\DB;

class SawHasilController extends App
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = \Auth::id();
        $hasils = SawHasil::with([
                'lamaran.pelamar.user',
                'sawKriteria',
            ])
            ->whereHas(
                'lamaran.pekerjaan', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->get();
        $saw_kriterias = SawKriteria::all();
        $lamarans = Lamaran::with(['pelamar.user'])
            ->whereHas(
                'pekerjaan', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->get();

        return view('soal/hasil', compact(['hasils', 'saw_kriterias', 'lamarans']));
    }

    /**
     * Display a listing of peringkat.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPeringkat()
    {
        $userId = \Auth::id();
        $peringkats = SawPeringkat::with([
                'lamaran.pelamar.user',
                'lamaran.sawHasils',
            ])
            ->whereHas(
                'lamaran.pekerjaan', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->orderBy('nilai', 'desc')
            ->get();
        $saw_kriterias = SawKriteria::all();

        return view('soal/peringkat', compact(['peringkats', 'saw_kriterias']));
    }

    /**
     * Hitung urutan peringkat.
     *
     * @return \Illuminate\Http\Response
     */
    public function hitungPeringkat()
    {
        $userId = \Auth::id();
        $alternatives = Lamaran::with([
                'pelamar.user',
                'sawHasils',
            ])
            ->whereHas(
                'pekerjaan',
                function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->get();
        $totalBobot = SawKriteria::select(
            DB::raw('sum(bobot) as bobot')
        )->first()->bobot;
        $nilaiMax = SawHasil::select(
                DB::raw('max(nilai) as nilai'),
                'saw_kriterias.bobot as bobot',
                'saw_kriteria_id'
            )
            ->whereHas(
                'lamaran.pekerjaan', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->join('saw_kriterias', 'saw_hasils.saw_kriteria_id', 'saw_kriterias.id')
            ->groupBy('saw_kriteria_id', 'bobot')
            ->get();
        $fuzzies = Fuzzy::all();

        try {
            SawPeringkat::whereHas(
                    'lamaran.pekerjaan', function($query) use ($userId) {
                        $query->where('user_id', $userId);
                    }
                )
                ->delete(); // Mengosongkan Data
            foreach ($alternatives as $alternative) {
                // Normalisasi
                $saw_normalisasi = [];
                foreach ($alternative->sawHasils as $hasil) {
                    foreach ($nilaiMax as $max) {
                        if ($max->saw_kriteria_id == $hasil->saw_kriteria_id) {
                            array_push($saw_normalisasi, (object)[
                                'saw_kriteria_id' => $max->saw_kriteria_id,
                                'bobot' => $max->bobot,
                                'nilai' => $hasil->nilai / $max->nilai,
                            ]);
                        }
                    }
                }
                $alternative->saw_normalisasi = $saw_normalisasi;
                $alternative->saw_peringkat = (object) [
                    'lamaran_id' => $alternative->id,
                    'nilai' => 0
                ];

                // Perangkingan
                foreach ($alternative->saw_normalisasi as $normalisasi) {
                    $alternative->saw_peringkat->nilai += $normalisasi->nilai * ($normalisasi->bobot * $totalBobot);
                }
                $nilai = $alternative->saw_peringkat->nilai * 100;
                // Fuzzy Logic
                foreach ($fuzzies as $fuzzy) {
                    if ((!$fuzzy->min || ($fuzzy->min && $fuzzy->min < $nilai))
                        && (!$fuzzy->max || ($fuzzy->max && $fuzzy->max >= $nilai))
                    ) {
                        $alternative->saw_peringkat->nilai_fuzzy = $fuzzy->nilai;
                    }
                }

                // Save
                SawPeringkat::create((array) $alternative->saw_peringkat);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect('HRD/tes/peringkat');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateHRD(Request $request, $id)
    {
        return $this->update($request, $id, \Auth::user()->type);
    }
}
