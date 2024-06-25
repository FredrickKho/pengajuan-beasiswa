<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBeasiswa extends Model
{
    protected $table = 'pengajuan_beasiswa';

    protected $fillable = [
        'beasiswa_id',
        'isApprovedByDekan',
        'dekan_id',
        'isApprovedByProgramStudi',
        'program_studi_id',
        'dekan_notes',
        'program_studi_notes',
        'dekan_update_at',
        'program_studi_update_at',
        'isFinalized'
    ];
        public function beasiswa(){
            return $this->belongsTo(Beasiswa::class,'beassiwa_id','id');
        }
        public function dekan(){
            return $this->belongsTo(Dekan::class);
        }
        public function programStudi(){
            return $this->belongsTo(ProgramStudi::class);
        }
    use HasFactory;
}
