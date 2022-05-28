<?php

namespace App\Http\Controllers;

use App\Fuzzy;
use Illuminate\Http\Request;
use App\SawHasil;
use App\SawKriteria;
use App\Lamaran;
use App\SawPeringkat;
use Illuminate\Support\Facades\DB;

class SawHasilController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hasils = SawHasil::with([
            'lamaran.pelamar.user',
            'sawKriteria',
        ])->get();
        $saw_kriterias = SawKriteria::all();
        $lamarans = Lamaran::with(['pelamar.user'])->get();

        return view('soal/hasil', compact(['hasils', 'saw_kriterias', 'lamarans']));
    }

    /**
     * Display a listing of peringkat.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPeringkat()
    {
        $peringkats = SawPeringkat::with([
            'lamaran.pelamar.user',
            'lamaran.sawHasils',
        ])
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
        $alternatives = Lamaran::with([
            'pelamar.user',
            'sawHasils',
        ])->get();
        $totalBobot = SawKriteria::select(
            DB::raw('sum(bobot) as bobot')
        )->first()->bobot;
        $nilaiMax = SawHasil::select(
            DB::raw('max(nilai) as nilai'),
            'saw_kriterias.bobot as bobot',
            'saw_kriteria_id'
        )
        ->join('saw_kriterias', 'saw_hasils.saw_kriteria_id', 'saw_kriterias.id')
        ->groupBy('saw_kriteria_id', 'bobot')
        ->get();
        $fuzzies = Fuzzy::all();

        try {
            SawPeringkat::truncate(); // Mengosongkan Data
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

        return redirect('tes/peringkat');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'saw_kriteria_id' => 'nullable|exists:saw_kriterias,id',
            'lamaran_id' => 'nullable|exists:lamarans,id',
            'nilai' => 'required',
        ]);

        try {
            $soal = SawHasil::create($data);
        } catch (Exception $e) {
            abort(422, 'Gagal menyimpan hasil baru.');
        }

        return redirect('tes/hasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'saw_kriteria_id' => 'nullable|exists:saw_kriterias,id',
            'lamaran_id' => 'nullable|exists:lamarans,id',
            'nilai' => 'required',
        ]);

        try {
            if (! $hasil = SawHasil::find($id)) {
                abort(422, 'Hasil tidak ditemukan.');
            }

            $hasil->saw_kriteria_id = $data['saw_kriteria_id'];
            $hasil->lamaran_id = $data['lamaran_id'];
            $hasil->nilai = $data['nilai'];

            $hasil->save();
        } catch (Exception $e) {
            abort(422, 'Gagal mengupdate soal baru.');
        }

        return redirect('tes/hasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            SawHasil::where('id', $id)->delete();
        } catch (Exception $e) {
            abort(422, 'Gagal menghapus data.');
        }

        return redirect('tes/hasil');
    }
}
