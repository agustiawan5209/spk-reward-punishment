<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $table = 'departements';

    protected $fillable = [
        'nama',
    ];

    public function staff()
    {
        return $this->hasMany(Staff::class, 'departement_id', 'id');
    }

    protected $appends = [
        'jumlah_karyawan',
    ];

    public function jumlahKaryawan(): Attribute
    {
        return new Attribute(
            get: fn() => $this->staff->count(),
            // set: null,
        );
    }


    //  FIlter Data User
    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })->when($filter['order'] ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }
}
