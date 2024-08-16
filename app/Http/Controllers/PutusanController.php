<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Keputusan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;


class PutusanController extends Controller
{
    public function index(){
        $tableName = 'keputusans'; // Ganti dengan nama tabel yang Anda inginkan
        // $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        $columns[] = 'jenis_putusan';
        $columns[] = 'point';
        $columns[] = 'alasan';
        $columns[] = 'tgl_putusan';

        return Inertia::render('Putusan/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'posyandus_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Keputusan::with(['karyawan','kategoripenilaian'])->filter(Request::only('search', 'order'))
                ->where('staff_id', '=', Auth::user()->staff->id)
                ->paginate(10),
            'can' => [
                'add' => false,
                'edit' => false,
                'show' => true,
                'delete' => false,
            ]
        ]);
    }

     /**
     * Display the specified resource.
     */
    public function show(Keputusan $keputusan)
    {
        Request::validate([
            'slug'=> 'required|exists:staff,id',
        ]);
        return Inertia::render('Putusan/Show', [
            'putusan' => $keputusan->with(['karyawan','kategoripenilaian'])->find(Request::input('slug')),
        ]);
    }
}
