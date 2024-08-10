<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        "staff_id",
        "staff",
        "aspek_id",
        "kriteria_id",
        "nilai",
        "tgl_penilaian",
    ];
    protected $casts = [
        "staff" => "json",
        "kriteria" => "json",
    ];

    public function staff()
    {
        return $this->hasOne(Staff::class, "id", "staff_id");
    }

    public function aspekkriteria()
    {
        return $this->hasOne(AspekKriteria::class, "id", "aspek_id");
    }
}
