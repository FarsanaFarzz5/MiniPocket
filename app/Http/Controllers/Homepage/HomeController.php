<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // 🏠 Display the start page
    public function index()
    {
        return view('start');
    }
}
