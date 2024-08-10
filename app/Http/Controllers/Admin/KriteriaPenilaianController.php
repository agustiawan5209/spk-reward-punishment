<?php

namespace App\Http\Controllers\Admin;

use App\Models\KriteriaPenilaian;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKriteriaPenilaianRequest;
use App\Http\Requests\UpdateKriteriaPenilaianRequest;
use App\Models\AspekKriteria;
use App\Models\SubKriteria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class KriteriaPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'kriteria_penilaians'; // Ganti dengan nama tabel yang Anda inginkan
        // $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        // $columns[] = 'nama_aspek';
        $columns[] = 'nama';
        $columns[] = 'nilai_target';
        $columns[] = 'factory';

        return Inertia::render('Admin/Kriteria/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'posyandus_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => KriteriaPenilaian::filter(Request::only('search', 'order'))
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
        return Inertia::render('Admin/Kriteria/Form',[
            'aspek'=> AspekKriteria::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKriteriaPenilaianRequest $request)
    {
        $kriteria = KriteriaPenilaian::create($request->all());

        $sub_nama_kriteria = $request->sub_nama_kriteria;
        $sub_bobot_kriteria = $request->sub_bobot_kriteria;

        for($i = 0; $i < count($sub_nama_kriteria); $i++){
            SubKriteria::create([
                'kriteria_id'=> $kriteria->id,
                'nama'=> $sub_nama_kriteria[$i],
                'bobot'=> $sub_bobot_kriteria[$i],
            ]);
        }
        return redirect()->route('Kriteria.index')->with('message', 'Berhasil Di Tambah!!');

    }

    /**
     * Display the specified resource.
     */
    public function show(KriteriaPenilaian $kriteriaPenilaian)
    {
        return Inertia::render('Admin/Kriteria/Show',[
            'kriteria'=> $kriteriaPenilaian->with(['subkriteria'])->find(Request::input('slug')),
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KriteriaPenilaian $kriteriaPenilaian)
    {
        return Inertia::render('Admin/Kriteria/Edit',[
            'aspek'=> AspekKriteria::all(),
            'kriteria'=> $kriteriaPenilaian->with(['subkriteria'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKriteriaPenilaianRequest $request, KriteriaPenilaian $kriteriaPenilaian)
    {
        $kriteria = $kriteriaPenilaian->find(Request::input('slug'));
        $kriteria->update($request->all());

        SubKriteria::where('kriteria_id', $kriteria->id)->delete();
        $sub_nama_kriteria = $request->sub_nama_kriteria;
        $sub_bobot_kriteria = $request->sub_bobot_kriteria;

        for($i = 0; $i < count($sub_nama_kriteria); $i++){
            SubKriteria::create([
                'kriteria_id'=> $kriteria->id,
                'nama'=> $sub_nama_kriteria[$i],
                'bobot'=> $sub_bobot_kriteria[$i],
            ]);
        }

        return redirect()->route('Kriteria.index')->with('message', 'Berhasil Di Ubah!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KriteriaPenilaian $kriteriaPenilaian)
    {
        $kriteria = $kriteriaPenilaian->find(Request::input('slug'));

        return redirect()->route('Kriteria.index')->with('message', 'Berhasil Di Hapus!!');
    }
}
