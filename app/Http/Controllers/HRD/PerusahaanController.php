<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\PerusahaanController as App;
use App\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends App
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = \Auth::id();
        $perusahaans = Perusahaan::where('user_id', $userId)->get();

        return view('perusahaan/index', compact('perusahaans'));
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
