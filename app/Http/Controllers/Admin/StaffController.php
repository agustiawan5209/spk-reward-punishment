<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\StoreStaffRequest;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Departement;

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
        // $columns[] = 'nama_departement';
        $columns[] = 'nama';
        $columns[] = 'nomor_telepon';
        $columns[] = 'jabatan';
        $columns[] = 'alamat';
        // dd($columns);
        return Inertia::render('Admin/Staff/Index', [
            'search' =>  Request::input('search'),
            'table_colums' => array_values(array_diff($columns, ['posyandus_id','remember_token', 'password', 'email_verified_at', 'created_at', 'updated_at', 'user_id'])),
            'data' => Staff::filter(Request::only('search', 'order'))->with(['user'])
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $columns_staff = DB::getSchemaBuilder()->getColumnListing('staff');
        $columns_user = DB::getSchemaBuilder()->getColumnListing('users');
        $columns_hide = ['remember_token', 'email_verified_at', 'created_at', 'updated_at', 'user_id', 'id', 'name'];
        $colums = array_diff(array_merge($columns_staff, $columns_user), $columns_hide);
        $colums['2'] =  [
            'name' => 'jabatan',
            'value' => Role::whereNot('name', 'Staff')->get(),
        ];
        // dd($colums);
        return Inertia::render('Admin/Staff/Form', [
            'jabatan' => Role::whereNot('name', 'Admin')->get(),
            'departement'=> Departement::all(),
            'colums' => array_values($colums),
            'linkCreate' => 'Staff.store',

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
            'phone' => $request->no_telpon,

        ]);
        $role = Role::findByName($request->jabatan);
        if ($role) {
            $user->assignRole($role); // Assign 'user' role to the user
            $user->givePermissionTo([
                'add penilaian',
                'edit penilaian',
                'delete penilaian',
                'show penilaian',
            ]);
        }


        event(new Registered($user));

        Staff::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'jabatan' => $request->jabatan,
            'departement_id' => $request->departement_id,
            'alamat' => $request->alamat,
        ]);
        return redirect()->route('Staff.index')->with('message', 'Data Staff berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        Request::validate([
            'slug'=> 'required|exists:staff,id',
        ]);
        return Inertia::render('Admin/Staff/Show', [
            'staff' => $staff->with(['departement','user'])->find(Request::input('slug')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        Request::validate([
            'slug'=> 'required|exists:staff,id',
        ]);
        return Inertia::render('Admin/Staff/Edit', [
            'staff' => $staff->with(['user'])->find(Request::input('slug')),
            'jabatan' => Role::whereNot('name', 'Admin')->get(),
            'departement'=> Departement::all(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {

        $staff = Staff::find(Request::input('slug'));

        $user = User::find($staff->user_id);
        $user->update([
            'name' => $request->name,
            // 'username' => $request->username,
            // 'email' => $request->email,
            // 'password' => Hash::make($request->password),
            // 'remember_token' => Str::random(60),
            'phone' => $request->no_telpon,
        ]);
        $user->syncRoles([]);

        $role = Role::findByName($request->jabatan);
        if ($role) {
            $user->assignRole($role); // Assign 'user' role to the user
            $user->givePermissionTo([
                'add penilaian',
                'edit penilaian',
                'delete penilaian',
                'show penilaian',
            ]);
        }



        $staff->update([
            'nama' => $request->name,
            'alamat' => $request->alamat,
            'departement_id' => $request->departement_id,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('Staff.index')->with('message', 'Data Staff berhasil Di Edit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff = Staff::with(['user'])->find(Request::input('slug'));
        $user_id = $staff->user->id;
        User::find($user_id)->delete();
        return redirect()->route('Staff.index')->with('message', 'Data Staff berhasil Di Hapus!');
    }



   /**
     * Display the specified resource.
     */
    public function resetpassword(Staff $staff)
    {

        return Inertia::render('Admin/Staff/UpdatePassword', [
            'user' => User::find(Request::input('slug')),
        ]);
    }
    public function resetpasswordUpdate(Staff $staff)
    {

        Request::validate([
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);


        $user = User::find(Request::input('slug'));
        $user->update([
            'remember_token' => Str::random(60),
            'password' => Hash::make(Request::input('password')),
        ]);
        return redirect()->route('Staff.index')->with('message', 'Password Staff berhasil Di Ubah!');

    }
}
