<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_kriterias';

    protected $fillable = [
        'kriteria_id',
        'nama',
        'bobot',
    ];

    public function kriteriapenilaian(){
        return $this->hasOne(KriteriaPenilaian::class,'id','kriteria_id');
    }
}
