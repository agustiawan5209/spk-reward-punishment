<?php

namespace App\Http\Controllers\Kepala;

use Inertia\Inertia;
use App\Models\Staff;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'staff'; // Ganti dengan nama tabel yang Anda inginkan
        // $columns=DB::getSchemaBuilder()->getColumnListing($tableName);
        $columns[] = 'id';
        $columns[] = 'nama_departement';
        $columns[] = 'nama';
        $columns[] = 'nomor_telepon';
        $columns[] = 'jabatan';
        $columns[] = 'alamat';
        // dd($columns);
        return Inertia::render('Kepala/Staff/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['posyandus_id','remember_token', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Staff::filter(Request::only('search', 'order'))
            ->with(['user'])
            ->when(Auth::user()->hasRole('Kepala Bagian'), function($query){
                $query->where('departement_id', Auth::user()->staff->departement_id);
            })
            ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add staff'),
                'edit' => Auth::user()->can('edit staff'),
                'show' => Auth::user()->can('show staff'),
                'delete' => Auth::user()->can('delete staff'),
                'reset' => Auth::user()->can('reset staff'),
            ]
        ]);
    }

    public function show(Staff $staff)
    {
        Request::validate([
            'slug'=> 'required|exists:staff,id',
        ]);
        return Inertia::render('Kepala/Staff/Show', [
            'staff' => $staff->with(['departement','user'])->find(Request::input('slug')),
        ]);
    }
}
