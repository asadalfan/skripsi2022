<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perusahaan;

class PerusahaanController extends Controller
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
        $perusahaans = Perusahaan::get();

        return view('perusahaan/index', compact('perusahaans'));
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
            'name' => 'required|string',
            'description' => 'nullable',
            'address' => 'required|string',
        ]);

        if (! Perusahaan::create($data)) {
            abort(422, 'Gagal menyimpan perusahaan baru.');
        }

        return redirect('perusahaan');
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
            'name' => 'required|string',
            'description' => 'nullable',
            'address' => 'required|string',
        ]);

        if (! Perusahaan::where('id', $id)->update($data)) {
            abort(422, 'Gagal melakukan update data.');
        }

        return redirect('perusahaan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Perusahaan::where('id', $id)->delete()) {
            abort(422, 'Gagal menghapus data.');
        }

        return redirect('perusahaan');
    }
}
