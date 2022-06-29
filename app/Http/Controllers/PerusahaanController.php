<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perusahaan;
use Illuminate\Support\Facades\Auth;

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
        $perusahaans = Perusahaan::all();

        return view('perusahaan/index', compact('perusahaans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userType = '')
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable',
            'address' => 'required|string',
        ]);

        $data = array_merge(['user_id' => Auth::id()], $data);

        if (! Perusahaan::create($data)) {
            abort(422, 'Gagal menyimpan perusahaan baru.');
        }

        return redirect($userType . '/perusahaan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $userType = '')
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable',
            'address' => 'required|string',
        ]);

        if (! Perusahaan::where('id', $id)->update($data)) {
            abort(422, 'Gagal melakukan update data.');
        }

        return redirect($userType . '/perusahaan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $userType = '')
    {
        if (! Perusahaan::where('id', $id)->delete()) {
            abort(422, 'Gagal menghapus data.');
        }

        return redirect($userType . '/perusahaan');
    }
}
