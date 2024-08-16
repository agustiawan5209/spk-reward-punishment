<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\KategoriPenilaian;
use App\Models\Keputusan;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'data' => [
                'staff' => Staff::when(Auth::user()->hasRole('Staff') || Auth::user()->hasRole('Kepala Bagian'), function ($query) {
                    $query->where('departement_id', '=', Auth::user()->staff->departement_id);
                })
                    ->count(),
                'departement' => Departement::all()->count(),
                'evaluasi' => KategoriPenilaian::all()->count(),
                'punishment' => Keputusan::where('jenis_putusan', '=', 'punishment')
                    ->when(Auth::user()->hasRole('Staff') || Auth::user()->hasRole('Kepala Bagian'), function ($query) {
                        $query->where('staff_id', '=', Auth::user()->staff->id);
                    })
                    ->count(),
                'reward' => Keputusan::where('jenis_putusan', '=', 'reward')
                    ->when(Auth::user()->hasRole('Staff') || Auth::user()->hasRole('Kepala Bagian'), function ($query) {
                        $query->where('staff_id', '=', Auth::user()->staff->id);
                    })
                    ->count(),
            ]
        ]);
    }
}
