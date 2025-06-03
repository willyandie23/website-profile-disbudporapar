<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index()
    {
        // Mengambil semua data file yang dapat diunduh
        $downloads = Download::orderBy('id', 'asc')->get();

        return view('frontend.download.index', compact('downloads'))
            ->with([
                'submenu' => false,
                'navbar' => true,
                'footer' => true
            ]);
    }

    public function incrementDownload($id)
    {
        // Meningkatkan jumlah unduhan file yang dipilih
        $download = Download::findOrFail($id);
        $download->increment('total_download');  // Menambahkan 1 ke total_download
        return response()->json(['message' => 'Download count incremented']);
    }
}
