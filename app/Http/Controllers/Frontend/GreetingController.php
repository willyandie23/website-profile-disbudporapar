<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GreetingController extends Controller
{
    public function index () {
        try {
            $organizations = Organization::where('position', 'Kepala Dinas')->get();

            // Mengembalikan view dengan data bidang dan anggota
            return view('frontend.greeting.index', compact('organizations'))->with([
                'submenu' => false,
                'navbar'  => true,
                'footer'  => true,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('/')->with('error', 'Bidang tidak ditemukan.');
        }
    }
}
