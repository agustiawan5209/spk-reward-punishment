<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Penilaian;
use App\Models\KategoriPenilaian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StorePenilaianRequest;
use App\Http\Requests\UpdatePenilaianRequest;
use App\Models\Alternatif;
use App\Models\AspekKriteria;
use App\Models\DataPenilaian;
use App\Models\Keputusan;
use App\Models\KriteriaPenilaian;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use ProfileMatching;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'kategori_penilaians'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        // $columns[] = 'id';
        // $columns[] = 'nama_aspek';
        // $columns[] = 'nama';
        // $columns[] = 'nilai_target';
        // $columns[] = 'factory';

        return Inertia::render('Penilaian/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'posyandus_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => KategoriPenilaian::with(['alternatif', 'penilaian'])->filter(Request::only('search', 'order'))
                ->where('status', 'aktif')
                ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add kriteria'),
                'edit' => Auth::user()->can('edit kriteria'),
                'show' => Auth::user()->can('show kriteria'),
                'delete' => Auth::user()->can('delete kriteria'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $valid = Validator::make(Request::all(), [
            'kategori' => 'required|exists:kategori_penilaians,id',
        ]);
        if ($valid->fails()) {
            return redirect()->route('Penilaian.index')->with('message', 'Kategori Harus Di Pilih');
        }

        // dd(Auth::user()->staff->departement_id);
        $alternatif = Alternatif::with(['staff', 'staff.departement'])
            ->when(Auth::user()->hasRole('Staff'), function ($query) {
                $query->whereHas('staff', function ($query) {
                    $query->where('departement_id', '=', Auth::user()->staff->departement_id);
                });
            })
            ->where('kategori_id', Request::input('kategori'))
            ->get();
        return Inertia::render('Penilaian/Form', [
            'alternatif' => $alternatif,
            'aspek' => AspekKriteria::all(),
            'kriteria' => KriteriaPenilaian::with(['subkriteria'])
                ->when(Request::has('aspek_id'), function ($query, $aspek) {
                    $query->where('aspek_id', $aspek);
                })->get(),
            'aspek_kriteria' => AspekKriteria::when(Request::has('aspek_id'), function ($query, $aspek) {
                $query->where('id', $aspek);
            })->first(),
            'kategori' => KategoriPenilaian::with(['alternatif', 'alternatif.staff', 'alternatif.staff.departement'])
                ->find(Request::input('kategori')),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenilaianRequest $request)
    {
        // dd($request->all());
        $kategori_id = $request->kategori;
        $kategori = KategoriPenilaian::with(['alternatif', 'alternatif.staff', 'alternatif.staff.departement'])->find($kategori_id);
        $aspek = AspekKriteria::find($request->aspek_id);

        // dd($aspek);
        $staff_penilai = Staff::find(Auth::user()->staff->id);
        $tgl_penilaian = $request->has('tgl_penilaian') ? $request->tgl_penilaian : Carbon::now()->format('Y-m-d');
        // Data Matrix Penilaian Karyawan
        $data = $request->kriteria;

        for ($i = 0; $i < count($data); $i++) {
            // Pecah data karyawan
            $kriteria = $data[$i]['kriteria'];
            $staff = $data[$i]['staffId'];
            $data_kriteria = $data[$i]['data_kriteria'];

            $penilaian = Penilaian::create([
                'kategori_id' => $kategori->id,
                'kategori' => $kategori,
                'aspek_id' => $aspek->id,
                'aspek' => $aspek,
                'staff_penilai_id' => $staff_penilai->id,
                'staff_penilai' => $staff_penilai,
                'staff_id' => $staff['id'],
                'staff' => $staff,
                'tgl_penilaian' => $tgl_penilaian,
            ]);
            for ($k = 0; $k < count($kriteria); $k++) {
                $kriteria_object = $kriteria[$k];
                DataPenilaian::create([
                    'penilaian_id' => $penilaian->id,
                    'kriteria_id' => $data_kriteria[$k]['kriteria_id'],
                    'kriteria' => $data_kriteria[$k]['kriteria'],
                    'nilai' => $kriteria_object,
                ]);
            }
        }

        return redirect()->route('Penilaian.index')->with('message', 'Penialaian Berhasil Di Buat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penilaian $penilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penilaian $penilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenilaianRequest $request, Penilaian $penilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penilaian $penilaian)
    {
        //
    }


    public function riwayat()
    {
        $tableName = 'kategori_penilaians'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        return Inertia::render('Penilaian/Riwayat', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'posyandus_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => KategoriPenilaian::with(['alternatif', 'penilaian'])->filter(Request::only('search', 'order'))
                ->where('status', 'aktif')
                ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add kriteria'),
                'edit' => Auth::user()->can('edit kriteria'),
                'show' => Auth::user()->can('show kriteria'),
                'delete' => Auth::user()->can('delete kriteria'),
            ]
        ]);
    }
    public function riwayat_show()
    {
        $kategori_id = Request::input('slug');
        $profileMatching = new ProfileMatchingController($kategori_id);
        $mtx = $profileMatching->matrixPenilai();
        $rank = $profileMatching->resultRank();
        return Inertia::render('Penilaian/RiwayatShow', [
            'kategori' => KategoriPenilaian::with(['alternatif', 'alternatif.staff', 'penilaian'])->find(Request::input('slug')),
            'penilaian' => Penilaian::with(['datapenilaian'])->where('kategori_id', Request::input('slug'))->get(),
            'perhitungan' => $mtx,
            'rank' => $rank,
            'aspek' => AspekKriteria::with(['kriteriapenilaian'])->find(1),
            'keputusan'=> Keputusan::with(['karyawan', 'kategoripenilaian'])->where('kategori_id', '=', $kategori_id)->get(),
            'can' => [
                'add' => Auth::user()->can('add penilaian'),
                'edit' => Auth::user()->can('edit penilaian'),
                'show' => Auth::user()->can('show penilaian'),
                'delete' => Auth::user()->can('delete penilaian'),
            ]
        ]);
    }
}
