<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspek_id',
        'nama',
        'bobot',
        'factory',
        'nilai_target',

    ];

    public function aspekkriteria(){
        return $this->hasOne(AspekKriteria::class, 'id','aspek_id');
    }

    public function subkriteria(){
        return $this->hasMany(SubKriteria::class,'kriteria_id','id');
    }

    protected $appends = [
        'nama_aspek',
    ];

    public function namaAspek(): Attribute
    {
        return new Attribute(
            get: fn()=> $this->aspekkriteria->nama,
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
