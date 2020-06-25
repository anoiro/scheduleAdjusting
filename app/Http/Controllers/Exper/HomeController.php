<?php

namespace App\Http\Controllers\Exper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:exper');
    }

    public function index()
    {
        //return view('exper.home');
        return view('exper.index');
    }
}