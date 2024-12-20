<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'user_id',
        'kode_pegawai',
        'nama',
        'jabatan',
        'departement_id',
        'alamat',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departement()
    {
        return $this->hasOne(Departement::class, 'id', 'departement_id');
    }

    protected $appends = [
        'nomor_telepon',
        'nama_departement',
    ];

    public function nomorTelepon(): Attribute
    {
        return new Attribute(
            get: fn() => $this->user->phone,
            // set: null,
        );
    }
    public function namaDepartement(): Attribute
    {
        return new Attribute(
            get: fn() => $this->departement->nama,
            // set: null,
        );
    }



    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('jabatan', 'like', '%' . $search . '%');
        })->when($filter['order'] ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }
}
