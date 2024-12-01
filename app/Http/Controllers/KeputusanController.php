<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Keputusan;
use App\Http\Requests\StoreKeputusanRequest;
use App\Http\Requests\UpdateKeputusanRequest;
use App\Models\KategoriPenilaian;

class KeputusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreKeputusanRequest $request)
    {
        // dd($request);
        $staff = $request->staff;

        $keputusan = Keputusan::where('kategori_id', '=', $request->kategori_id)->get();

        if($keputusan->count() > 0){
            Keputusan::where('kategori_id', '=', $request->kategori_id)->delete();
        }
        for ($i = 0; $i < count($staff); $i++){
            $karyawan = Staff::with(['departement', 'user'])->find($staff[$i]['staff']['id']);
            Keputusan::create([
                'kategori_id'=> $request->kategori_id,
                'kategori'=> $request->kategori,
                'staff_id'=> $karyawan->id,
                'staff'=> $karyawan,
                'alasan'=> $staff[$i]['alasan'],
                'point'=> $staff[$i]['point'],
                'hasil'=> $staff[$i]['hasil'],
                'jenis_putusan'=> $staff[$i]['putusan'],
                'tgl_putusan'=> $request->tgl_putusan,

            ]);
        }
        $kategori = KategoriPenilaian::find($request->kategori_id)->update([
            'status'=> 'tidak aktif'
        ]);

        return redirect()->route('admin.riwayat.show', ['slug'=> $request->kategori_id])->with('message', "Data Putusan :". $request->kategori['nama']. " Berhasil Dibuat!!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Keputusan $keputusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keputusan $keputusan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKeputusanRequest $request, Keputusan $keputusan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keputusan $keputusan)
    {
        //
    }
}
