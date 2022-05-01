<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function home()
    {
        return view('dashboard.home.index');
    }
}
