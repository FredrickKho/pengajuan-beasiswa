<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
        'jurusan_id',
        'user_id'
    ];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function jurusan(){
        return $this->belongsTo(KategoriJurusan::class,'jurusan_id');
    }
}
