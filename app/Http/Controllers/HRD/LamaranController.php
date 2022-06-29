<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\LamaranController as App;
use App\Lamaran;
use App\Pekerjaan;
use App\Pelamar;
use Illuminate\Http\Request;

class LamaranController extends App
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = \Auth::id();
        $lamarans = Lamaran::with(['pelamar', 'pekerjaan'])
            ->whereHas(
                'pekerjaan', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->get();
        $pekerjaans = Pekerjaan::where('user_id', $userId)->get();

        return view('lamaran/index', compact([
            'lamarans',
            'pekerjaans',
        ]));
    }

    /**
     * Display a listing of the verifikasi resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verifikasi()
    {
        $userId = \Auth::id();
        $lamarans = Lamaran::with(['pelamar.user', 'diverifikasiOleh'])
            ->whereHas(
                'pekerjaan', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->get();

        return view('lamaran/verifikasi', compact([
            'lamarans',
        ]));
    }

    /**
     * Terima specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verifiedHRD(Request $request, $id)
    {
        return $this->verified($request, $id, \Auth::user()->type);
    }

    /**
     * Terima specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unverifiedHRD(Request $request, $id)
    {
        return $this->unverified($request, $id, \Auth::user()->type);
    }

    /**
     * Display a listing of the hasil resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hasil()
    {
        $userId = \Auth::id();
        $lamarans = Lamaran::with(['pelamar.user', 'diterimaOleh'])
            ->where('diverifikasi', true)
            ->whereHas(
                'pekerjaan',
                function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->get();

        return view('lamaran/hasil', compact([
            'lamarans',
        ]));
    }

    /**
     * Terima specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function terimaHRD(Request $request, $id)
    {
        return $this->terima($request, $id, \Auth::user()->type);
    }

    /**
     * Terima specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tolakHRD(Request $request, $id)
    {
        return $this->tolak($request, $id, \Auth::user()->type);
    }
}
