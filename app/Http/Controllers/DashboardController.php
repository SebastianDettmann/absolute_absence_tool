<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    /**
     * Display a listing of all \App\Access belongs to an user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $accesses = auth()->user()->accesses;

        return view('dashbord')->with([
            'accesses' => $accesses,
        ]);
    }
}
