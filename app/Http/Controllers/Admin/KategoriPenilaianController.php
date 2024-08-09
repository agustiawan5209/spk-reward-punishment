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

class KategoriPenilaianController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriPenilaianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriPenilaian $kategoriPenilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriPenilaian $kategoriPenilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriPenilaianRequest $request, KategoriPenilaian $kategoriPenilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriPenilaian $kategoriPenilaian)
    {
        //
    }
}
