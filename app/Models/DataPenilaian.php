<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPenilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        "penilaian_id",
        "kriteria_id",
        "kriteria",

        // Nilai Bobot Yang Diberikan
        "nilai",
    ];
    protected $casts = [
        "kriteria" => "json",
    ];

    public function penilaian(){
        return $this->belongsTo(Penilaian::class);
    }
}
