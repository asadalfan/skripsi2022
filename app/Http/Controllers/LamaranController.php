<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lamaran;
use App\Pelamar;
use App\Pekerjaan;
use Illuminate\Support\Facades\Hash;

class LamaranController extends Controller
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
        $lamarans = Lamaran::with(['pelamar', 'pekerjaan'])->get();
        $pelamars = Pelamar::with(['user'])->get();
        $pekerjaans = Pekerjaan::all();

        return view('lamaran/index', compact([
            'lamarans',
            'pelamars',
            'pekerjaans',
        ]));
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
            'pelamar_id' => 'required|exists:pelamars,id',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'cv' => 'nullable|file|max:20000000',
        ]);

        try {
            if ($request->hasFile('cv')) {
                $filenameWithExt = $request->file('cv')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('cv')->getClientOriginalExtension();
                $filenameSave = 'CV_' . time() . '_' . $data['pelamar_id'] . '.' . $extension;
                $path = $request->file('cv')->storeAs('public/cv', $filenameSave);
            }

            $lamaran = Lamaran::create([
                'pelamar_id' => $data['pelamar_id'],
                'pekerjaan_id' => $data['pekerjaan_id'],
                'files' => json_encode([
                    'cv' => $filenameSave
                ]),
            ]);
        } catch (Exception $e) {
            abort(422, 'Gagal menyimpan lamaran baru.');
        }        

        return redirect('lamaran');
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
            'pelamar_id' => 'required|exists:pelamars,id',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'cv' => 'nullable|file|max:20000000',
        ]);

        try {
            $lamaran = Lamaran::find($id);
            $fileJson = json_decode($lamaran->files);

            if ($request->hasFile('cv')) {
                $filenameWithExt = $request->file('cv')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('cv')->getClientOriginalExtension();
                $filenameSave = 'CV_' . time() . '_' . $data['pelamar_id'] . '.' . $extension;
                $path = $request->file('cv')->storeAs('public/cv', $filenameSave);
                $fileJson->cv = $filenameSave;
                $lamaran->files = json_encode($fileJson);
            }

            $lamaran->pelamar_id = $data['pelamar_id'];
            $lamaran->pekerjaan_id = $data['pekerjaan_id'];
            $lamaran->save();
        } catch (Exception $e) {
            abort(422, 'Gagal mengupdate lamaran.');
        }        

        return redirect('lamaran');
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
            $lamaran = Lamaran::find($id)->delete();
        } catch (Exception $e) {
            abort(422, 'Gagal menghapus data.');
        }

        return redirect('lamaran');
    }
}
