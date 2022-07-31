<?php

namespace App\Http\Controllers;

use App\Pekerjaan;

class GuestController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pekerjaans = Pekerjaan::where('diverifikasi', 1)
            ->get();

        return view('welcome', compact(['pekerjaans']));
    }
}
