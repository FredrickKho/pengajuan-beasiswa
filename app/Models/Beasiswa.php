<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    protected $table = 'beasiswa';

    protected $fillable = [
        'mahasiswa_id',
        'period_id',
        'category_id',
        'ipk',
        'transkrip_akademik',
        'surat_rekomendasi_dosen',
        'surat_pernyataan_beasiswa',
        'bukti_keaktifan',
        'dokumen_pendukung_lain'
    ];
    public function period(){
        return $this->belongsTo(Period::class);
    }
    public function category(){
        return $this->belongsTo(KategoriBeasiswa::class);
    }
    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class);
    }
    public function pengajuanBeasiswa(){
        return $this->hasOne(PengajuanBeasiswa::class,'beasiswa_id','id');
    }
    use HasFactory;
}
