<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriJurusan extends Model
{
    protected $table = 'kategori_jurusan';

    protected $fillable = [
        'name'
    ];
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class,'jurusan_id','id');
    }
    use HasFactory;
}
