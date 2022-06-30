<?php

namespace App\Http\Controllers;

use App\Pelamar;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $users = User::orderBy('created_at', 'desc')->get();
        $types = [
            [
                'title' => 'HRD',
                'value' => 'HRD',
            ],
            [
                'title' => 'Tim Seleksi',
                'value' => 'tim-seleksi',
            ],
            [
                'title' => 'Pelamar',
                'value' => 'pelamar',
            ],
            [
                'title' => 'Admin',
                'value' => 'admin',
            ],
        ];

        return view('user/index', compact('users', 'types'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'type' => ['required', 'string'],
        ]);

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => $data['type'],
            ]);
    
            if ($data['type'] == 'pelamar') {
                Pelamar::create([
                    'user_id' => $user->id,
                    'address' => '-',
                ]);
            }
        } catch (\Throwable $th) {
            abort(422, 'Gagal menyimpan user baru.');
        }

        return redirect('user');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'type' => ['string'],
        ]);

        try {
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }

            $user = User::where('id', $id)
                ->update($data);
        } catch (\Throwable $th) {
            abort(422, 'Gagal melakukan update data.');
        }

        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! User::where('id', $id)->delete()) {
            abort(422, 'Gagal menghapus data.');
        }

        return redirect('user');
    }
}
