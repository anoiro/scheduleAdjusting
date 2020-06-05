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
        //dd(11);
        return view('exper.home');
    }
}