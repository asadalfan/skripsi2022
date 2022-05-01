<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perusahaan;
use App\SawKriteria;
use App\Tag;
use App\Taggable;

class SawKriteriaController extends Controller
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
        $soals = SawKriteria::all();
        $tags = Tag::all();

        return view('soal/index', compact(['soals', 'tags']));
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
            'type' => 'nullable|string',
            'description' => 'nullable',
            'options' => 'nullable|array',
            'answers' => 'nullable|array',
            'tags' => 'required|array',
            'use_options' => 'nullable',
        ]);

        if (! isset($data['use_options'])) {
            $data['options'] = null;
            $data['answers'] = null;
        }

        try {
            if ($data['answers']) {
                $options = [];
                for ($i=0; $i < count($data['options']); $i++) { 
                    array_push($options, [
                        'value' => $data['options'][$i],
                        'is_true' => $i == $data['answers'][0] ? true : false
                    ]);
                }
                $data['options'] = json_encode($options);
            }

            $soal = SawKriteria::create($data);

            foreach ($data['tags'] as $tag) {
                Taggable::create([
                    'tag_id' => $tag,
                    'taggable_id' => $soal->id,
                    'taggable_type' => $soal->getMorphClass()
                ]);
            }
        } catch (Exception $e) {
            abort(422, 'Gagal menyimpan soal baru.');
        }

        return redirect('tes/soal');
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
            'type' => 'nullable|string',
            'description' => 'nullable',
            'options' => 'nullable|array',
            'answers' => 'nullable|array',
            'tags' => 'required|array',
            'use_options' => 'nullable',
        ]);

        if (! isset($data['use_options'])) {
            $data['options'] = null;
            $data['answers'] = null;
        }

        try {
            $soal = SawKriteria::find($id);

            if ($data['answers']) {
                $options = [];
                for ($i=0; $i < count($data['options']); $i++) { 
                    array_push($options, [
                        'value' => $data['options'][$i],
                        'is_true' => $i == $data['answers'][0] ? true : false
                    ]);
                }
                $data['options'] = json_encode($options);
            }

            $soal->type = $data['type'];
            $soal->description = $data['description'];
            $soal->options = $data['options'];

            $soal->save();

            Taggable::where('taggable_id', $id)->where('taggable_type', (new SawKriteria)->getMorphClass())->delete();

            foreach ($data['tags'] as $tag) {
                Taggable::create([
                    'tag_id' => $tag,
                    'taggable_id' => $soal->id,
                    'taggable_type' => $soal->getMorphClass()
                ]);
            }
        } catch (Exception $e) {
            abort(422, 'Gagal mengupdate soal baru.');
        }

        return redirect('tes/soal');
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
            SawKriteria::where('id', $id)->delete();
            Taggable::where('taggable_id', $id)->where('taggable_type', (new SawKriteria)->getMorphClass())->delete();
        } catch (Exception $e) {
            abort(422, 'Gagal menghapus data.');
        }

        return redirect('tes/soal');
    }
}
