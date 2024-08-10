<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\KategoriPenilaian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreKategoriPenilaianRequest;
use App\Http\Requests\UpdateKategoriPenilaianRequest;
use App\Models\Alternatif;
use App\Models\Departement;

class KategoriPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'kategori_penilaians'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);


        return Inertia::render('Admin/Kategori/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'posyandus_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => KategoriPenilaian::filter(Request::only('search', 'order'))
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
        return Inertia::render('Admin/Kategori/Form', [
            'departement'=> Departement::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriPenilaianRequest $request)
    {

        $kategoriPenilaian = KategoriPenilaian::create($request->all());

        // Tambah Alternatif Karyawan
        $alternatif = $request->data_karyawan;
        for ($i = 0; $i < count($alternatif); $i++){

            // Cek Status Data karyawan apakah masuk dalam daftar enilaian atau tidak;
            if($alternatif[$i]['status']){
                 Alternatif::create([
                    'kategori_id'=> $kategoriPenilaian->id,
                    'staff_id'=> $alternatif[$i]['staff_id'],
                    'status'=> '0',
                ]);
            }
        }
        return redirect()->route('Kategori.index')->with('message','Data Berhasil Di Tambah!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriPenilaian $kategoriPenilaian)
    {
        return Inertia::render('Admin/Kategori/Show', [
            'kategori'=> $kategoriPenilaian->with(['alternatif', 'alternatif.staff'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriPenilaian $kategoriPenilaian)
    {
        return Inertia::render('Admin/Kategori/Edit', [
            'kategori'=> $kategoriPenilaian->with(['alternatif', 'alternatif.staff'])->find(Request::input('slug')),
            'departement'=> Departement::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriPenilaianRequest $request, KategoriPenilaian $kategoriPenilaian)
    {
        $kategoriPenilaian = KategoriPenilaian::find($request->slug);
        $kategoriPenilaian->update($request->all());

        // Tambah Alternatif Karyawan
        Alternatif::where('kategori_id', $kategoriPenilaian->id)->delete();
        $alternatif = $request->data_karyawan;

        for ($i = 0; $i < count($alternatif); $i++){
            // Cek Status Data karyawan apakah masuk dalam daftar enilaian atau tidak;
            if($alternatif[$i]['status'] || $alternatif[$i]['status'] == '0'){
                 Alternatif::create([
                    'kategori_id'=> $kategoriPenilaian->id,
                    'staff_id'=> $alternatif[$i]['staff_id'],
                    'status'=> '0',
                ]);
            }
        }

        return redirect()->route('Kategori.index')->with('message','Data Berhasil Di Ubah!!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriPenilaian $kategoriPenilaian)
    {
        $kategoriPenilaian->with('alternatif')->find(Request::input('slug'))->delete();
        return redirect()->route('Kategori.index')->with('message','Data Berhasil Di hapus!!');

    }
}
