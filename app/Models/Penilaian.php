<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        "kategori_id",
        "kategori",
        // Aspek Yang Dinilai
        "aspek_id",
        "aspek",

        // Penilai
        "staff_penilai_id",
        "staff_penilai",

        // Karyawan Yang Dinilai
        "staff_id",
        "staff",

        // Tanggal Penilaian
        "tgl_penilaian",
    ];
    protected $casts = [
        "kategori" => "json",
        "staff" => "json",
        "kriteria" => "json",
        'tgl_penilaian'=> 'date'
    ];

    public function staff()
    {
        return $this->hasOne(Staff::class, "id", "staff_id");
    }
    public function penilai()
    {
        return $this->hasOne(Staff::class, "id", "staff_penilai_id");
    }

    public function aspekkriteria()
    {
        return $this->hasOne(AspekKriteria::class, "id", "aspek_id");
    }

    public function datapenilaian(){
        return $this->hasMany(DataPenilaian::class, 'penilaian_id','id');
    }
}
