<?php

namespace App\Http\Controllers;

use App\Reason;
use App\User;

class ReportingController extends Controller
{

    /**
     * Display a listing of Users with Periods of the current year
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::with(['periods' => function ($query) {
            $query->byCurrentYear();
        }])->orderBy('lastname')->get();
        $reasons = Reason::get();

        return view('reporting.index')->with([
            'users' => $users,
            'reasons' => $reasons,
        ]);
    }
}
