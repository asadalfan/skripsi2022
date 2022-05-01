<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SawHasil;
use App\SawKriteria;
use App\Lamaran;

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
        $lamarans = Lamaran::all();

        return view('soal/hasil', compact(['hasils', 'saw_kriterias', 'lamarans']));
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
