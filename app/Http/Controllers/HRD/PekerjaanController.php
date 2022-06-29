<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\PekerjaanController as App;
use App\Perusahaan;
use App\Pekerjaan;
use App\Tag;
use Illuminate\Http\Request;

class PekerjaanController extends App
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
        $pekerjaans = Pekerjaan::where('user_id', $userId)->get();
        $tags = Tag::all();

        return view('pekerjaan/index', compact(['perusahaans', 'pekerjaans', 'tags']));
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
