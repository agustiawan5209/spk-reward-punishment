<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AspekKriteria extends Model
{
    use HasFactory;

    protected $table = 'aspek_kriterias';

    protected $fillable = [
        'nama',
        'persentase',
        'bobot',
        'core_factory',
        'secondary_factory',
    ];


    public function kriteriapenilaian(){
        return $this->hasMany(KriteriaPenilaian::class, 'aspek_id','id');
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
