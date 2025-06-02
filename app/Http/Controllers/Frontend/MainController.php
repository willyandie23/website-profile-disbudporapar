<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('frontend.main.index', [
            'submenu'           => false,
            'navbar'            => true,
            'footer'            => true,
        ]);
    }
}
