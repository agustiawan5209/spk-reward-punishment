<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspek_id',
        'nama',
        'bobot'
    ];

    public function aspekkriteria(){
        return $this->belongsTo(AspekKriteria::class);
    }
}
