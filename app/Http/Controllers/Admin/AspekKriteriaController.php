<?php

namespace App\Http\Controllers\Admin;

use App\Models\AspekKriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAspekKriteriaRequest;
use App\Http\Requests\UpdateAspekKriteriaRequest;
use App\Models\KriteriaPenilaian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class AspekKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'aspek_kriterias'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        return Inertia::render('Admin/Aspek/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'posyandus_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => AspekKriteria::filter(Request::only('search', 'order'))
                ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add aspek'),
                'edit' => Auth::user()->can('edit aspek'),
                'show' => Auth::user()->can('show aspek'),
                'delete' => Auth::user()->can('delete aspek'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Aspek/Form',[]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAspekKriteriaRequest $request)
    {
        $aspek = AspekKriteria::create($request->all());

        // $sub_nama_aspek = $request->sub_nama_aspek;
        // $sub_bobot_aspek = $request->sub_bobot_aspek;

        // for($i = 0; $i < count($sub_nama_aspek); $i++){
        //     KriteriaPenilaian::create([
        //         'aspek_id'=> $aspek->id,
        //         'nama'=> $sub_nama_aspek[$i],
        //         'bobot'=> $sub_bobot_aspek[$i],
        //     ]);
        // }
        return redirect()->route('Aspek.index')->with('message', 'Berhasil Di Tambah!!');

    }

    /**
     * Display the specified resource.
     */
    public function show(AspekKriteria $aspekKriteria)
    {
        return Inertia::render('Admin/Aspek/Show',[
            'aspek'=> $aspekKriteria->with(['kriteriapenilaian'])->find(Request::input('slug')),
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AspekKriteria $aspekKriteria)
    {
        return Inertia::render('Admin/Aspek/Edit',[
            'aspek'=> $aspekKriteria->with(['kriteriapenilaian'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAspekKriteriaRequest $request, AspekKriteria $aspekKriteria)
    {
        $aspek = $aspekKriteria->find(Request::input('slug'));
        $aspek->update($request->all());

        // KriteriaPenilaian::where('aspek_id', $aspek->id)->delete();
        // $sub_nama_aspek = $request->sub_nama_aspek;
        // $sub_bobot_aspek = $request->sub_bobot_aspek;

        // for($i = 0; $i < count($sub_nama_aspek); $i++){
        //     KriteriaPenilaian::create([
        //         'aspek_id'=> $aspek->id,
        //         'nama'=> $sub_nama_aspek[$i],
        //         'bobot'=> $sub_bobot_aspek[$i],
        //     ]);
        // }

        return redirect()->route('Aspek.index')->with('message', 'Berhasil Di Ubah!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AspekKriteria $aspekKriteria)
    {
        $aspek = $aspekKriteria->find(Request::input('slug'));

        return redirect()->route('Aspek.index')->with('message', 'Berhasil Di Hapus!!');
    }
}
