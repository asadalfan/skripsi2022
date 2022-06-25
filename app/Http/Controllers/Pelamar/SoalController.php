<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Lamaran;
use App\SawHasil;
use App\SawHasilDetail;
use Illuminate\Http\Request;
use App\Soal;
use App\Tag;
use App\SawKriteria;
use Exception;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kriteria_id, $lamaran_id)
    {
        $lamaran = Lamaran::where('id', $lamaran_id)->first();
        $soals = Soal::where('saw_kriteria_id', $kriteria_id)
            ->where('pekerjaan_id', $lamaran->pekerjaan_id)
            ->get();
        $kriteria = SawKriteria::find($kriteria_id);

        return view('pelamar/soal/index-pelamar', compact([
            'lamaran',
            'soals',
            'kriteria',
        ]));
    }

    /**
     * Store hasil tes resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function selesai(Request $request, $kriteria_id, $lamaran_id)
    {
        $soalCount = 0;
        $corrects = 0;
        try {
            $hasil = SawHasil::updateOrCreate(
                [
                    'lamaran_id' => $lamaran_id,
                    'saw_kriteria_id' => $kriteria_id,
                ],
                [
                    'nilai' => null
                ]
            );
        } catch (Exception $e) {
            toastr()->error('Gagal menyimpan hasil!');
            abort(422, 'Gagal menyimpan hasil!');
        }

        try {
            foreach ($request->input() as $key => $req) {
                if ($key != '_token') {
                    $soalCount++;
                    $reqs = explode('~~~', $req);
                    if (isset($reqs[1]) && $reqs[1] == 'correct') {
                        $corrects++;
                    }
                    SawHasilDetail::updateOrCreate(
                        [
                            'saw_hasil_id' => $hasil->id,
                            'soal_id' => $key,
                        ],
                        [
                            'answer' => $reqs[0]
                        ]
                    );
                }
            }
        } catch (Exception $e) {
            toastr()->error('Gagal menyimpan soal baru!');
            abort(422, 'Gagal menyimpan soal baru!');
        }

        try {
            $kriteria = SawKriteria::find($kriteria_id);
            $hasil->nilai = strtolower($kriteria->nama) == 'wawancara' ? null : $corrects / $soalCount * 100;
            $hasil->save();
        } catch (Exception $e) {
            toastr()->error('Gagal menilai tes!');
            abort(422, 'Gagal menilai tes!');
        }

        return redirect('pelamar/tes/hasil');
    }
}
