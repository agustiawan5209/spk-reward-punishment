<?php

namespace App\Http\Controllers\Sekretariat;

use Inertia\Inertia;
use App\Models\Keputusan;
use App\Models\Penilaian;
use App\Models\AspekKriteria;
use App\Models\KategoriPenilaian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ProfileMatchingController;

class PenilaianController extends Controller
{
    public function index()
    {
        $tableName = 'kategori_penilaians'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        return Inertia::render('Sekretariat/Penilaian/Riwayat', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'posyandus_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => KategoriPenilaian::with(['alternatif', 'penilaian'])->filter(Request::only('search', 'order'))
                // ->where('status', 'aktif')
                ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add kriteria'),
                'edit' => Auth::user()->can('edit kriteria'),
                'show' => true,
                'delete' => Auth::user()->can('delete kriteria'),
            ]
        ]);
    }
    public function show()
    {
        $kategori_id = Request::input('slug');
        $profileMatching = new ProfileMatchingController($kategori_id);
        $mtx = $profileMatching->matrixPenilai();
        $rank = $profileMatching->resultRank();
        $rank = array_values($rank);
        // dd($rank);
        return Inertia::render('Sekretariat/Penilaian/RiwayatShow', [
            'kategori' => KategoriPenilaian::with(['alternatif', 'alternatif.staff', 'penilaian'])->find(Request::input('slug')),
            'penilaian' => Penilaian::with(['datapenilaian'])->where('kategori_id', Request::input('slug'))->get(),
            'perhitungan' => $mtx,
            'rank' => $rank,
            'aspek' => AspekKriteria::with(['kriteriapenilaian'])->find(1),
            'keputusan'=> Keputusan::with(['karyawan', 'kategoripenilaian'])->where('kategori_id', '=', $kategori_id)->get(),
            'can' => [
                'add' => true,
                'edit' => Auth::user()->can('edit penilaian'),
                'show' => true,
                'delete' => Auth::user()->can('delete penilaian'),
            ]
        ]);
    }
}
