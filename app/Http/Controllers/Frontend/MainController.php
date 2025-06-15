<?php

namespace App\Http\Controllers\Frontend;

use App\Models\News;
use App\Models\Field;
use App\Models\Banner;
use App\Models\Galery;
use App\Models\Download;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Identity;

class MainController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        $latestNews = News::orderBy('created_at', 'desc')->limit(2)->get();
        $latestDownloads = Download::orderBy('created_at', 'desc')->limit(10)->get();
        $gallerys = Galery::orderBy('created_at', 'desc')->limit(6)->get();

        $employeeCount = Organization::count();
        $newsCount = News::count();
        $fieldCount = Field::count();

        // Mengelompokkan organisasi berdasarkan posisi mereka
        $organizations = Organization::with('field')->get();
        $head_of_department = $organizations->whereIn('position',
            [
                'Kepala Dinas', 
                'KEPALA DINAS', 
                'Plt. Kepala Dinas', 
                'Plt. KEPALA DINAS'
            ]
        );
        $secretariat = $organizations->whereIn('position', 
            [
                'Plt. SEKRETARIS',
                'SEKRETARIS',
                'Plt. Sekretaris',
                'Sekretaris'
            ]
        );

        // Mengelompokkan berdasarkan bidang
        $cultural_department = $organizations->where('position', 'KEPALA BIDANG KEBUDAYAAN');
        $tourism_department = $organizations->where('position', 'KEPALA BIDANG PARIWISATA');
        $youth_department = $organizations->where('position', 'KEPALA BIDANG KEPEMUDAAN');
        $sports_department = $organizations->where('position', 'KEPALA BIDANG OLAHRAGA');
        
        $youtube_video = Identity::where('key', 'site_ytb')->first();
        
        $youtube_value = $youtube_video->value;

        return view('frontend.main.index', [
            'submenu' => false,
            'navbar' => true,
            'footer' => true,
            'banners' => $banners,
            'latestNews' => $latestNews,
            'latestDownloads' => $latestDownloads,
            'gallerys' => $gallerys,
            'employeeCount' => $employeeCount,
            'newsCount' => $newsCount,
            'fieldCount' => $fieldCount,
            'head_of_department' => $head_of_department,
            'secretariat' => $secretariat,
            'cultural_department' => $cultural_department,
            'tourism_department' => $tourism_department,
            'youth_department' => $youth_department,
            'sports_department' => $sports_department,
            'youtube_value' => $youtube_value,
        ]);
    }
}
