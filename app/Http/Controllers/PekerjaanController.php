<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perusahaan;
use App\Pekerjaan;
use App\Tag;
use App\Taggable;

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

        try {
            if (! $pekerjaan = Pekerjaan::create($data)) {
                abort(422, 'Gagal menyimpan pekerjaan baru.');
            }

            foreach ($data['tags'] as $tag) {
                if (! Taggable::create([
                    'tag_id' => $tag,
                    'taggable_id' => $pekerjaan->id,
                    'taggable_type' => $pekerjaan->getMorphClass()
                ])) {
                    abort(422, 'Gagal menyimpan kategori pekerjaan.');
                }
            }
        } catch (Exception $e) {
            abort(422, $e);
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
            'name' => 'required|string',
            'description' => 'nullable',
            'address' => 'required|string',
        ]);

        if (! Pekerjaan::where('id', $id)->update($data)) {
            abort(422, 'Gagal melakukan update data.');
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
        if (! Pekerjaan::where('id', $id)->delete()) {
            abort(422, 'Gagal menghapus data.');
        }

        if (! Taggable::where('taggable_id', $id)->where('taggable_type', Pekerjaan::getMorphClass())->delete()) {
            abort(422, 'Gagal menghapus data.');
        }

        return redirect('pekerjaan');
    }
}
