<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Gap;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StoreGapRequest;
use App\Http\Requests\UpdateGapRequest;

class GapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableName = 'gaps'; // Ganti dengan nama tabel yang Anda inginkan
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        return Inertia::render('Admin/Gap/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['remember_token', 'posyandus_id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Gap::filter(Request::only('search', 'order'))
                ->paginate(10),
            'can' => [
                'add' => Auth::user()->can('add gap'),
                'edit' => Auth::user()->can('edit gap'),
                'show' => Auth::user()->can('show gap'),
                'delete' => Auth::user()->can('delete gap'),
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
    public function store(StoreGapRequest $request)
    {
        Gap::create($request->all());

        return redirect()->route('Gap.index')->with('message', 'Data Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gap $gap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gap $gap)
    {
        return response()->json($gap->find(Request::input('slug')), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGapRequest $request, Gap $gap)
    {
        Gap::find($request->id)->update($request->all());

        return redirect()->route('Gap.index')->with('message', 'Data Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gap $gap)
    {
        Gap::find(Request::input('slug'))->delete();

        return redirect()->route('Gap.index')->with('message', 'Data Berhasil Di Hapus');
    }
}
