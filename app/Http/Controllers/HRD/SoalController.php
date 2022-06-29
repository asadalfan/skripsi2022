<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\SoalController as App;
use App\Pekerjaan;
use App\Soal;
use App\Tag;
use App\SawKriteria;

class SoalController extends App
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->validate([
            'cari' => 'nullable',
            'cari_kriteria_id' => 'nullable|exists:saw_kriterias,id',
        ]);

        $saw_kriterias = SawKriteria::all();
        $cariKriteriaId = \Arr::get($data, 'cari_kriteria_id') ?? (($saw_kriterias->first() ? $saw_kriterias->first()->id : null));

        $user = \Auth::user();
        $soals = Soal::with([
            'sawKriteria',
            'user',
            'pekerjaan',
        ])
        ->when(
            $cari = \Arr::get($data, 'cari'), function($query) use ($cari) {
                $query->where('description', 'LIKE', '%'.$cari.'%');
            }
        )
        ->when(
            $cariKriteriaId, function($query) use ($cariKriteriaId) {
                $query->where('saw_kriteria_id', $cariKriteriaId);
            }
        )
        ->when(
            $user->type != 'admin', function($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        )
        ->whereHas(
            'pekerjaan', function($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        )
        ->get();
        $tags = Tag::all();
        $pekerjaans = Pekerjaan::when($user->type != 'admin', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('soal/index', compact([
            'soals',
            'tags',
            'saw_kriterias',
            'cariKriteriaId',
            'pekerjaans',
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeHRD(Request $request)
    {
        return $this->store($request, \Auth::user()->type);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyHRD($id)
    {
        return $this->destroy($id, \Auth::user()->type);
    }
}
