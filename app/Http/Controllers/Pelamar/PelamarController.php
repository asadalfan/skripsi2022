<?php

namespace App\Http\Controllers\Pelamar;

use Illuminate\Http\Request;
use App\Pelamar;
use App\Http\Controllers\PelamarController as App;
use Illuminate\Support\Facades\Auth;

class PelamarController extends App
{
    /**
     * Display the specified resource.
     *
     */
    public function showProfile()
    {
        $pelamars = Pelamar::with(['user'])->where('user_id', \Auth::user()->id)->get();

        return view('pelamar/index', compact('pelamars'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {
        if (Auth::user()->id != Pelamar::find($id)->user->id) {
            toastr()->error('Anda tidak memiliki izin mengupdate profile ini!');
            abort(403);
        }

        $this->_update($request, $id);

        return redirect('profile');
    }
}
