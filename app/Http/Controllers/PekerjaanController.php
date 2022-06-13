<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perusahaan;
use App\Pekerjaan;
use App\Tag;
use App\Taggable;
use Illuminate\Support\Facades\Auth;

class PekerjaanController extends Controller
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
        $pekerjaans = Pekerjaan::all();
        $tags = Tag::all();

        return view('pekerjaan/index', compact(['perusahaans', 'pekerjaans', 'tags']));
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
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'name' => 'required|string',
            'description' => 'nullable',
            'tags' => 'required|array',
        ]);

        $data = array_merge(['user_id' => Auth::id()], $data);

        try {
            $pekerjaan = Pekerjaan::create($data);

            foreach ($data['tags'] as $tag) {
                Taggable::create([
                    'tag_id' => $tag,
                    'taggable_id' => $pekerjaan->id,
                    'taggable_type' => $pekerjaan->getMorphClass()
                ]);
            }
        } catch (Exception $e) {
            abort(422, 'Gagal menyimpan pekerjaan baru.');
        }

        return redirect('pekerjaan');
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
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'name' => 'required|string',
            'description' => 'nullable',
            'tags' => 'required|array',
        ]);

        try {
            $pekerjaan = Pekerjaan::find($id);

            $pekerjaan->perusahaan_id = $data['perusahaan_id'];
            $pekerjaan->name = $data['name'];
            $pekerjaan->description = $data['description'];

            $pekerjaan->save();

            Taggable::where('taggable_id', $id)->where('taggable_type', (new Pekerjaan)->getMorphClass())->delete();

            foreach ($data['tags'] as $tag) {
                Taggable::create([
                    'tag_id' => $tag,
                    'taggable_id' => $pekerjaan->id,
                    'taggable_type' => $pekerjaan->getMorphClass()
                ]);
            }
        } catch (Exception $e) {
            abort(422, 'Gagal mengupdate pekerjaan.');
        }

        return redirect('pekerjaan');
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
            Pekerjaan::where('id', $id)->delete();
            Taggable::where('taggable_id', $id)->where('taggable_type', (new Pekerjaan)->getMorphClass())->delete();
        } catch (Exception $e) {
            abort(422, 'Gagal menghapus data.');
        }

        return redirect('pekerjaan');
    }

    /**
     * Display a listing of the verifikasi resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verifikasi()
    {
        $pekerjaans = Pekerjaan::with(['tags', 'perusahaan', 'diverifikasiOleh'])->get();

        return view('pekerjaan/verifikasi', compact([
            'pekerjaans',
        ]));
    }

    /**
     * Terima specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verified(Request $request, $id)
    {
        $data = $request->validate([
            'catatan_diverifikasi' => 'nullable|string',
        ]);

        try {
            $pekerjaan = Pekerjaan::find($id);

            $pekerjaan->diverifikasi = true;
            $pekerjaan->diverifikasi_pada = now();
            $pekerjaan->diverifikasi_oleh = Auth::id();
            $pekerjaan->catatan_diverifikasi = $data['catatan_diverifikasi'];
            $pekerjaan->save();
        } catch (Exception $e) {
            abort(422, 'Gagal memverifikasi pekerjaan.');
        }

        return redirect('pekerjaan/verifikasi');
    }

    /**
     * Terima specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unverified(Request $request, $id)
    {
        $data = $request->validate([
            'catatan_diverifikasi' => 'nullable|string',
        ]);

        try {
            $pekerjaan = Pekerjaan::find($id);

            $pekerjaan->diverifikasi = false;
            $pekerjaan->diverifikasi_pada = now();
            $pekerjaan->diverifikasi_oleh = Auth::id();
            $pekerjaan->catatan_diverifikasi = $data['catatan_diverifikasi'];
            $pekerjaan->save();
        } catch (Exception $e) {
            abort(422, 'Gagal mengunverifikasi pekerjaan.');
        }

        return redirect('pekerjaan/verifikasi');
    }
}
