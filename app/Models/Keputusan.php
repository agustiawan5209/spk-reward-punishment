<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keputusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'kategori',
        'staff_id',
        'staff',
        'alasan',
        'point',
        'jenis_putusan',
        'tgl_putusan',
    ];

    protected $casts = [
        'kategori'=> 'json',
        'staff'=> 'json',
    ];

    public function kategoripenilaian()
    {
        return $this->belongsTo(KategoriPenilaian::class, 'kategori_id', 'id');
    }

    public function karyawan()
    {
        return $this->hasOne(Staff::class, 'id', 'staff_id');
    }

    //  FIlter Data User
    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->where('staff', 'like', '%' . $search . '%')
                ->orWhere('alasan', 'like', '%' . $search . '%')
                ->orWhereDate('tgl_putusan', 'like', '%' . $search . '%')
                ->orWhereDate('jenis_putusan', 'like', '%' . $search . '%');
        })->when($filter['order'] ?? null, function ($query, $order) {
            $query->orderBy('id', $order);
        });
    }
}
