<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    protected $fillable = [
        'user_id',
        'nama',
        'jabatan',
        'departement_id',
        'alamat',
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function departement(){
        return $this->hasOne(Departement::class,'id','departement_id');
    }
}
